#!/usr/bin/env bash
# Rejoue le chargeur de l'espace client (story 1.12) contre le WordPress Docker local.
# Vérifie la lecture du manifeste sur des manifestes de test, puis la page « Mon
# espace » servie avec un faux CDN déposé dans src/ (même origine), le repli sur le
# dernier manifeste valide et le message d'échec. Sort en erreur au moindre écart.
#
# Prérequis : docker compose, curl, openssl, base WordPress importée.
# Variables : BASE_URL (http://localhost), PAGE_PATH (/mon-espace),
#             COMPOSE (« docker compose », depuis la racine du dépôt).
# Le faux CDN est lu par WordPress depuis le conteneur : http://localhost y désigne
# son propre Apache.
set -uo pipefail

BASE_URL=${BASE_URL:-http://localhost}
PAGE_PATH=${PAGE_PATH:-/mon-espace}
COMPOSE=${COMPOSE:-docker compose}
RUN=$(date +%s)
WORK=$(mktemp -d)
CDN_PATH=spa-cdn-$RUN
CDN_URL=http://localhost/$CDN_PATH/
FAILURES=0

cd "$(dirname "$0")/../.."

cleanup() {
  wp_php 'require_once ABSPATH . "wp-admin/includes/user.php"; foreach (get_users(["search" => "*-" . $argv[1], "search_columns" => ["user_login"]]) as $u) { wp_delete_user($u->ID); } delete_transient("esthima_spa_assets"); delete_option("esthima_spa_assets_last");' "$RUN" >/dev/null
  rm -rf "src/$CDN_PATH" "$WORK"
  # Rend au service web la configuration de .env.
  $COMPOSE up -d web >/dev/null 2>&1
}
trap cleanup EXIT

check() { # libellé, commande de test…
  local label=$1; shift
  if "$@"; then echo "  ok   $label"; else echo "  FAIL $label"; FAILURES=$((FAILURES + 1)); fi
}

wp_php() { # code PHP, arguments…
  local code=$1; shift
  $COMPOSE exec -T -w /var/www/html web php -r "require 'wp-load.php'; $code" "$@" 2>/dev/null
}

start_web() { # REACT_APP_CDN_URL
  ESTHIMA_SPA_DEV= REACT_APP_CDN_URL=$1 $COMPOSE up -d web >/dev/null 2>&1
  for _ in $(seq 1 30); do
    [ "$(curl -s -o /dev/null -w '%{http_code}' "$BASE_URL$PAGE_PATH")" = 200 ] && return 0
    sleep 1
  done
  echo "WordPress ne répond pas sur $BASE_URL$PAGE_PATH" >&2
  exit 2
}

entry_key() { wp_php 'echo json_encode(esthima_spa_wordpress_entry_key(json_decode($argv[1], true)));' "$1"; }
css_files() { wp_php '$m = json_decode($argv[1], true); echo json_encode(esthima_spa_css_files($m, esthima_spa_wordpress_entry_key($m) ?? ""));' "$1"; }
forget_assets() { wp_php 'delete_transient("esthima_spa_assets");' >/dev/null; }
forget_last_valid() { wp_php 'delete_option("esthima_spa_assets_last");' >/dev/null; }

visit() { curl -s -o "$1.b" -b "$1" -c "$1" "$BASE_URL${2:-$PAGE_PATH}"; } # jar, [chemin]
has() { grep -q -- "$2" "$1.b"; } # jar, motif
not() { ! "$@"; }

VALID='{
  "src/entries/wordpress.tsx": {"file": "assets/wordpress-Aa11Bb22.js", "name": "wordpress", "isEntry": true, "imports": ["_shared-Cc33Dd44.js"], "css": ["assets/wordpress-Ee55Ff66.css"]},
  "_shared-Cc33Dd44.js": {"file": "assets/shared-Cc33Dd44.js", "css": ["assets/shared-Gg77Hh88.css"]}
}'
RENAMED=${VALID/\"name\": \"wordpress\"/\"name\": \"standalone\"}
DUPLICATED='{
  "src/entries/wordpress.tsx": {"file": "assets/wordpress-Aa11Bb22.js", "name": "wordpress", "isEntry": true},
  "src/entries/other.tsx": {"file": "assets/other-Ii99Jj00.js", "name": "wordpress", "isEntry": true}
}'
OUTSIDE=${VALID/assets\/wordpress-Aa11Bb22.js/wordpress-Aa11Bb22.js}
CSS_OUTSIDE=${VALID/assets\/shared-Gg77Hh88.css/shared-Gg77Hh88.css}

echo "Lecture des manifestes"
check "manifeste valide : entrée wordpress" test "$(entry_key "$VALID")" = '"src\/entries\/wordpress.tsx"'
check "CSS de l'import puis de l'entrée" test "$(css_files "$VALID")" = '["assets\/shared-Gg77Hh88.css","assets\/wordpress-Ee55Ff66.css"]'
check "entrée renommée : refusée" test "$(entry_key "$RENAMED")" = null
check "entrée wordpress en double : refusée" test "$(entry_key "$DUPLICATED")" = null
check "module hors de assets/ : refusé" test "$(entry_key "$OUTSIDE")" = null
check "CSS d'un import hors de assets/ : refusée" test "$(css_files "$CSS_OUTSIDE")" = null

# Faux CDN : le manifeste valide et des assets vides, servis par Apache depuis src/.
mkdir -p "src/$CDN_PATH/assets"
printf '%s' "$VALID" > "src/$CDN_PATH/manifest.json"
for file in wordpress-Aa11Bb22.js shared-Cc33Dd44.js wordpress-Ee55Ff66.css shared-Gg77Hh88.css; do : > "src/$CDN_PATH/assets/$file"; done
start_web "$CDN_URL"
forget_assets; forget_last_valid

USER_LOGIN=spa-replay-$RUN
USER_PASS=$(openssl rand -hex 16)
$COMPOSE exec -T -w /var/www/html -e USER_PASS="$USER_PASS" web php -r 'require "wp-load.php"; wp_insert_user(["user_login" => $argv[1], "user_email" => $argv[1] . "@example.test", "user_pass" => getenv("USER_PASS"), "role" => "customer"]);' "$USER_LOGIN" >/dev/null 2>&1

echo "Visiteur non connecté"
ANON="$WORK/anon"; : > "$ANON"; visit "$ANON"
check "lien de connexion" has "$ANON" 'wp-login.php?redirect_to='
check "titre et <main> de la page" eval "has '$ANON' '<h1 class=\"page-header__title\">Mon espace</h1>' && has '$ANON' '<main class=\"main main-content'"
check "ni module, ni point de montage, ni contexte hôte" eval "! has '$ANON' 'esthima-spa' && ! has '$ANON' 'id=\"esthima-espace-client\"' && ! has '$ANON' 'window.EsthimaUser'"

echo "Utilisateur connecté, manifeste valide"
JAR="$WORK/user"; : > "$JAR"
curl -s -o /dev/null -b "$JAR" -c "$JAR" "$BASE_URL/wp-login.php"
curl -s -o /dev/null -b "$JAR" -c "$JAR" --data-urlencode "log=$USER_LOGIN" --data-urlencode "pwd=$USER_PASS" -d 'testcookie=1&wp-submit=1' "$BASE_URL/wp-login.php"
visit "$JAR"
check "module de l'entrée" has "$JAR" "<script type=\"module\" src=\"${CDN_URL}assets/wordpress-Aa11Bb22.js\" id=\"esthima-spa-js-module\">"
check "CSS de l'import puis de l'entrée" eval "grep -o \"href='${CDN_URL}assets/[^']*'\" '$JAR.b' | tr '\n' ' ' | grep -q \"shared-Gg77Hh88.css'.*wordpress-Ee55Ff66.css'\""
check "point de montage, sans titre ni <main> du template" eval "has '$JAR' 'id=\"esthima-espace-client\"' && ! has '$JAR' 'page-header__title\">Mon espace' && ! has '$JAR' '<main class=\"main main-content'"
visit "$JAR" /
check "autre page : aucun asset de la SPA" eval "! has '$JAR' 'esthima-spa' && ! has '$JAR' '$CDN_PATH'"

echo "Manifeste retiré, dernier manifeste valide conservé"
rm "src/$CDN_PATH/manifest.json"; forget_assets; visit "$JAR"
check "le dernier manifeste valide sert" has "$JAR" 'id="esthima-spa-js-module"'

echo "Manifeste retiré, sans dernier manifeste valide"
forget_assets; forget_last_valid; visit "$JAR"
check "message d'échec" has "$JAR" 'ne peut pas être affiché pour le moment'
check "ni module ni point de montage" eval "! has '$JAR' 'esthima-spa-js-module' && ! has '$JAR' 'id=\"esthima-espace-client\"'"

echo
if [ "$FAILURES" -eq 0 ]; then echo "Tous les scénarios du chargeur sont conformes."; else echo "$FAILURES écart(s)."; fi
exit $(( FAILURES > 0 ))

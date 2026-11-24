#!/usr/bin/env bash
# Rejoue les scénarios SSO JWT (story 1.11) contre le WordPress Docker local.
# Génère une clé RSA de test à l'exécution, (re)démarre le service web avec la
# configuration SSO de test, puis vérifie connexions, refus, fermetures et logout.
# Sort en erreur si un scénario s'écarte du comportement attendu.
#
# Prérequis : docker compose, curl, openssl, python3, base WordPress importée.
# Variables : BASE_URL (http://localhost), PAGE_PATH (/mon-espace),
#             COMPOSE (« docker compose », depuis la racine du dépôt).
set -uo pipefail

BASE_URL=${BASE_URL:-http://localhost}
PAGE_PATH=${PAGE_PATH:-/mon-espace}
COMPOSE=${COMPOSE:-docker compose}
ISSUER=https://sso.test.invalid
AUDIENCE=esthima-wordpress-test
SSO_LOGOUT=https://sso.test.invalid/logout
RUN=$(date +%s)
WORK=$(mktemp -d)
HOST=$(python3 -c 'import sys, urllib.parse; print(urllib.parse.urlparse(sys.argv[1]).hostname)' "$BASE_URL")
FAILURES=0

cd "$(dirname "$0")/../.."

cleanup() {
  wp_php 'require_once ABSPATH . "wp-admin/includes/user.php"; foreach (get_users(["search" => "*-" . $argv[1], "search_columns" => ["user_login"]]) as $u) { wp_delete_user($u->ID); }' "$RUN" >/dev/null
  # Rend au service web la configuration SSO de .env.
  $COMPOSE up -d web >/dev/null 2>&1
  rm -rf "$WORK"
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

start_web() { # clé publique, iss, aud, url de logout SSO
  SSO_JWT_PUBLIC_KEY=$1 SSO_JWT_ISSUER=$2 SSO_JWT_AUDIENCE=$3 SSO_LOGOUT_URL=$4 $COMPOSE up -d web >/dev/null 2>&1
  for _ in $(seq 1 30); do
    [ "$(curl -s -o /dev/null -w '%{http_code}' "$BASE_URL$PAGE_PATH")" = 200 ] && return 0
    sleep 1
  done
  echo "WordPress ne répond pas sur $BASE_URL$PAGE_PATH" >&2
  exit 2
}

jwt() { # alg, clé privée (RS256) ou secret (HS256), claims JSON
  python3 - "$@" <<'PY'
import base64, hashlib, hmac, json, subprocess, sys
alg, key, claims = sys.argv[1:4]
b64 = lambda raw: base64.urlsafe_b64encode(raw).rstrip(b"=").decode()
signing_input = b64(json.dumps({"alg": alg, "typ": "JWT"}).encode()) + "." + b64(claims.encode())
if alg == "RS256":
    sig = subprocess.run(["openssl", "dgst", "-sha256", "-sign", key], input=signing_input.encode(), capture_output=True, check=True).stdout
elif alg == "HS256":
    sig = hmac.new(key.encode(), signing_input.encode(), hashlib.sha256).digest()
else:
    sig = b""
print(signing_input + "." + b64(sig))
PY
}

claims() { # sub, email, [JSON supplémentaire sans accolades]
  local now; now=$(date +%s)
  echo "{\"iss\":\"$ISSUER\",\"aud\":\"$AUDIENCE\",\"sub\":\"$1\",\"email\":\"$2\",\"firstName\":\"Test\",\"lastName\":\"Replay\",\"exp\":$((now + 600))${3:+,$3}}"
}

valid_jwt() { jwt RS256 "$WORK/sso.key" "$(claims "$@")"; }

new_jar() { local jar="$WORK/jar-$RANDOM"; : > "$jar"; echo "$jar"; }

set_jwt() { # jar, jeton (vide pour retirer)
  grep -v 'jwt_token' "$1" > "$1.tmp"; mv "$1.tmp" "$1"
  [ -n "${2:-}" ] && printf '%s\tFALSE\t/\tFALSE\t0\tjwt_token\t%s\n' "$HOST" "$2" >> "$1"
  return 0
}

visit() { curl -s -D "$1.h" -o "$1.b" -b "$1" -c "$1" "$BASE_URL$PAGE_PATH"; } # jar

opens_session() { grep -qi '^Set-Cookie: wordpress_logged_in_[^=]*=[^%;]' "$1.h"; }
closes_session() { grep -qi '^Set-Cookie: wordpress_logged_in_[^;]*; expires=[^;]*; Max-Age=0' "$1.h"; }
has_host_context() { grep -q 'window.EsthimaUser' "$1.b"; }
host_context() { grep -o 'window.EsthimaUser = [^;]*;' "$1.b" | sed 's/^window.EsthimaUser = //; s/;$//'; }
logout_url() { host_context "$1" | python3 -c 'import json, sys; print(json.load(sys.stdin)["logoutUrl"])'; }
user_email() { wp_php '$u = get_user_by("login", $argv[1]); echo $u ? $u->ID . " " . $u->user_email : "none";' "$1"; }
session_flags() { wp_php '$u = get_user_by("login", $argv[1]); echo json_encode(array_map(fn($s) => $s["sso"] ?? false, array_values(WP_Session_Tokens::get_instance($u->ID)->get_all())));' "$1"; }
expired_jwt_cookie() { grep -qi '^Set-Cookie: jwt_token=[^;]*; expires=[^;]*; Max-Age=0; path=/; domain=[^;]*; secure; HttpOnly' "$1"; }
location_is() { [ "$(grep -i '^Location:' "$1" | tr -d '\r' | cut -d' ' -f2-)" = "$2" ]; }
not() { ! "$@"; }

openssl genpkey -algorithm RSA -pkeyopt rsa_keygen_bits:2048 -out "$WORK/sso.key" 2>/dev/null
openssl pkey -in "$WORK/sso.key" -pubout -out "$WORK/sso.pub"
openssl genpkey -algorithm RSA -pkeyopt rsa_keygen_bits:2048 -out "$WORK/other.key" 2>/dev/null
# Comme dans .env : la clé PEM sur une ligne, avec des \n littéraux.
PUBLIC_KEY=$(awk 'BEGIN { ORS = "\\n" } 1' "$WORK/sso.pub")

SSO_USER=sso-replay-a-$RUN
NATIVE_USER=sso-replay-native-$RUN
NATIVE_PASS=$(openssl rand -hex 16)

start_web "$PUBLIC_KEY" "$ISSUER" "$AUDIENCE" "$SSO_LOGOUT"
$COMPOSE exec -T -w /var/www/html -e NATIVE_PASS="$NATIVE_PASS" web php -r 'require "wp-load.php"; wp_insert_user(["user_login" => $argv[1], "user_email" => $argv[1] . "@example.test", "user_pass" => getenv("NATIVE_PASS"), "role" => "customer"]);' "$NATIVE_USER" >/dev/null 2>&1

echo "JWT valide, compte inconnu"
JAR=$(new_jar); set_jwt "$JAR" "$(valid_jwt "$SSO_USER" "a-$RUN@example.test")"; visit "$JAR"
check "session WordPress ouverte" opens_session "$JAR"
check "compte créé avec login = sub" test "$(user_email "$SSO_USER" | cut -d' ' -f2)" = "a-$RUN@example.test"
check "session marquée sso" test "$(session_flags "$SSO_USER")" = "[true]"
check "contexte hôte limité à logoutUrl" python3 -c 'import json, sys; assert list(json.loads(sys.argv[1])) == ["logoutUrl"]' "$(host_context "$JAR")"
check "logoutUrl sans entité HTML" not grep -q '&amp;' <<< "$(host_context "$JAR")"
check "ni JWT ni panneau de debug dans la page" not grep -q -e 'SSO Debug' -e 'jwt_token' "$JAR.b"
ACCOUNT_ID=$(user_email "$SSO_USER" | cut -d' ' -f1)

echo "E-mail changé"
set_jwt "$JAR" "$(valid_jwt "$SSO_USER" "b-$RUN@example.test")"; visit "$JAR"
check "même compte, e-mail synchronisé" test "$(user_email "$SSO_USER")" = "$ACCOUNT_ID b-$RUN@example.test"
set_jwt "$JAR" "$(valid_jwt "$SSO_USER" "$NATIVE_USER@example.test")"; visit "$JAR"
check "e-mail déjà pris : synchro ignorée" test "$(user_email "$SSO_USER")" = "$ACCOUNT_ID b-$RUN@example.test"
check "e-mail déjà pris : session conservée" has_host_context "$JAR"

echo "JWT refusés"
NOW=$(date +%s)
refused() { # libellé, jeton
  local jar; jar=$(new_jar); set_jwt "$jar" "$2"; visit "$jar"
  check "$1 : aucune connexion" eval "! opens_session '$jar' && ! has_host_context '$jar'"
}
REFUSED_SUB=sso-replay-refused-$RUN
refused "signature d'une autre clé" "$(jwt RS256 "$WORK/other.key" "$(claims "$REFUSED_SUB" "r-$RUN@example.test")")"
refused "HS256 signé avec la clé publique" "$(jwt HS256 "$(cat "$WORK/sso.pub")" "$(claims "$REFUSED_SUB" "r-$RUN@example.test")")"
refused "alg none" "$(jwt none - "$(claims "$REFUSED_SUB" "r-$RUN@example.test")")"
refused "iss inattendu" "$(jwt RS256 "$WORK/sso.key" "{\"iss\":\"https://other.test.invalid\",\"aud\":\"$AUDIENCE\",\"sub\":\"$REFUSED_SUB\",\"exp\":$((NOW + 600))}")"
refused "aud inattendu" "$(jwt RS256 "$WORK/sso.key" "{\"iss\":\"$ISSUER\",\"aud\":[\"other\"],\"sub\":\"$REFUSED_SUB\",\"exp\":$((NOW + 600))}")"
refused "nbf futur" "$(jwt RS256 "$WORK/sso.key" "{\"iss\":\"$ISSUER\",\"aud\":\"$AUDIENCE\",\"sub\":\"$REFUSED_SUB\",\"nbf\":$((NOW + 300)),\"exp\":$((NOW + 600))}")"
refused "exp absent" "$(jwt RS256 "$WORK/sso.key" "{\"iss\":\"$ISSUER\",\"aud\":\"$AUDIENCE\",\"sub\":\"$REFUSED_SUB\"}")"
refused "exp passé" "$(jwt RS256 "$WORK/sso.key" "{\"iss\":\"$ISSUER\",\"aud\":\"$AUDIENCE\",\"sub\":\"$REFUSED_SUB\",\"exp\":$((NOW - 5))}")"
refused "sub vide" "$(jwt RS256 "$WORK/sso.key" "{\"iss\":\"$ISSUER\",\"aud\":\"$AUDIENCE\",\"sub\":\"\",\"exp\":$((NOW + 600))}")"
check "aucun compte créé par un JWT refusé" test "$(user_email "$REFUSED_SUB")" = none

echo "aud en tableau contenant l'audience"
ARRAY_JAR=$(new_jar)
set_jwt "$ARRAY_JAR" "$(jwt RS256 "$WORK/sso.key" "$(claims "sso-replay-array-$RUN" "array-$RUN@example.test" "\"aud\":[\"other\",\"$AUDIENCE\"]" | python3 -c 'import json, sys; print(json.dumps(json.loads(sys.stdin.read())))')")"
visit "$ARRAY_JAR"
check "accepté" opens_session "$ARRAY_JAR"

echo "JWT refusé sur une session sso ouverte"
set_jwt "$JAR" "$(jwt RS256 "$WORK/other.key" "$(claims "$SSO_USER" "b-$RUN@example.test")")"; visit "$JAR"
check "session WordPress fermée" closes_session "$JAR"
check "jeton de session détruit" test "$(session_flags "$SSO_USER")" = "[]"

echo "Cookie absent"
JAR=$(new_jar); set_jwt "$JAR" "$(valid_jwt "$SSO_USER" "b-$RUN@example.test")"; visit "$JAR"
set_jwt "$JAR" ""; visit "$JAR"
check "session sso fermée" eval "closes_session '$JAR' && ! has_host_context '$JAR'"
NATIVE_JAR=$(new_jar)
curl -s -o /dev/null -b "$NATIVE_JAR" -c "$NATIVE_JAR" "$BASE_URL/wp-login.php"
curl -s -o /dev/null -b "$NATIVE_JAR" -c "$NATIVE_JAR" --data-urlencode "log=$NATIVE_USER" --data-urlencode "pwd=$NATIVE_PASS" -d 'testcookie=1&wp-submit=1' "$BASE_URL/wp-login.php"
visit "$NATIVE_JAR"
check "session native conservée sans JWT" has_host_context "$NATIVE_JAR"
set_jwt "$NATIVE_JAR" "$(jwt RS256 "$WORK/other.key" "$(claims "$NATIVE_USER" "$NATIVE_USER@example.test")")"; visit "$NATIVE_JAR"
check "session native conservée avec un JWT refusé" has_host_context "$NATIVE_JAR"

echo "Logout natif (sans JWT)"
set_jwt "$NATIVE_JAR" ""; visit "$NATIVE_JAR"
NATIVE_REDIRECT="$BASE_URL/mon-compte/"
curl -s -D "$WORK/native-logout.h" -o /dev/null -b "$NATIVE_JAR" -c "$NATIVE_JAR" \
  "$(logout_url "$NATIVE_JAR")&redirect_to=$(python3 -c 'import sys, urllib.parse; print(urllib.parse.quote(sys.argv[1], safe=""))' "$NATIVE_REDIRECT")"
check "garde sa redirection native" location_is "$WORK/native-logout.h" "$NATIVE_REDIRECT"

echo "Logout depuis la page, avec SSO_LOGOUT_URL"
JAR=$(new_jar); set_jwt "$JAR" "$(valid_jwt "$SSO_USER" "b-$RUN@example.test")"; visit "$JAR"
curl -s -D "$WORK/logout.h" -o /dev/null -b "$JAR" -c "$JAR" "$(logout_url "$JAR")"
check "302" grep -q '^HTTP/[0-9.]* 302' "$WORK/logout.h"
check "jwt_token expiré (Domain, Path, Secure, HttpOnly)" expired_jwt_cookie "$WORK/logout.h"
check "redirection vers SSO_LOGOUT_URL" location_is "$WORK/logout.h" "$SSO_LOGOUT"
check "sessions détruites" test "$(session_flags "$SSO_USER")" = "[]"

echo "Logout depuis la page, sans SSO_LOGOUT_URL"
start_web "$PUBLIC_KEY" "$ISSUER" "$AUDIENCE" ""
JAR=$(new_jar); set_jwt "$JAR" "$(valid_jwt "$SSO_USER" "b-$RUN@example.test")"; visit "$JAR"
curl -s -D "$WORK/logout-home.h" -o /dev/null -b "$JAR" -c "$JAR" "$(logout_url "$JAR")"
check "redirection vers l'accueil" location_is "$WORK/logout-home.h" "$(wp_php 'echo home_url();')"

echo "Configuration incomplète"
start_web "$PUBLIC_KEY" "" "$AUDIENCE" ""
JAR=$(new_jar); set_jwt "$JAR" "$(valid_jwt "$SSO_USER" "b-$RUN@example.test")"; visit "$JAR"
check "iss vide : aucune connexion" not opens_session "$JAR"

echo
if [ "$FAILURES" -eq 0 ]; then echo "Tous les scénarios SSO sont conformes."; else echo "$FAILURES écart(s)."; fi
exit $(( FAILURES > 0 ))

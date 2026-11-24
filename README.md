Merci de suivre les étapes pour créer un docker avec une url permettant d'accéder à votre environnement local, une url pour accéder au PHPMYADMIN et une url pour un logiciel de catch email (mail catcher)

## Etape 1

- ouvrir le fichier .env
- changer la variable 'NAME_PROJECT' et 'PASSWORD'
- attention pas d'espaces, de majuscules, de tirets ou de caractères spéciaux dans le nom du projet

## Etape 2

### Modifier le vhosts

- Sur Windows : C:\WINDOWS\system32\drivers\etc\
- Sur Mac : /etc/hosts

```bash
127.0.0.1 local.NAME_PROJECT.com
```

### Si première installation d'un docker alors ajouter également dans votre vhosts :

```bash
127.0.0.1 local.pma.com
127.0.0.1 local.mailcatcher.com
```

## Etape 3

### Commande pour lancer le projet
lancer la commande
```bash
make run
```

Pour accèder au PHPMYADMIN
```bash
http://local.pma.com:8081/index.php
```

Pour accèder au MAIL CATCHER
```bash
http://local.mailcatcher.com:1080
```

## Etape 4

### Pour stopper le docker
lancer la commande
```bash
make stop
```

## Etape 5
En vous rendant sur l'URL local.NAME_PROJECT.com

Les sources web sont stockées dans le répertoire 'src'


## Etape pour Esthima

Rajouter les hosts dans son fichier host

```bash
127.0.0.1 local.esthima.com
127.0.0.1 local.pma.com
127.0.0.1 local.mailcatcher.com
```

Ouvrir un terminale via debian se positionner à la racine du projet et lancer 

```bash
docker-compose build
docker-compose up -d
```

## BDD LOCAL

Pour la bdd il faut lancer (si jamais quand elle n'existe plus dans l'image mysql)

```bash
make db
make dburl
```

`make db` n'importe que la base `esthima` du dump, dont les URLs sont celles de la production : `make dburl` les remplace par `http://local.esthima.com`.

## BDD REMOTE

remarque il faut bien avoir ses clefs ssh dans ~/.ssh

```bash
make sshdb
```

## TRANSPILATION

Pour lancer webpack il faut aller dans l'image du serveur web on peut passer via le docker-desktop et ensuite on se rend dans le themes et on lance
```bash
npm i && npm run dev
```
tu peux lancer les commandes via make:
npm install
```bash
make npmi
```
npm run dev
```bash
make npmdev
```

Pour accéder à debian via l'explorateur (à mettre dans la barre)
```bash
\\wsl$
```

## Espace client (page « Mon espace »)

La page `http://local.esthima.com/mon-espace` (template `tracking.php`) monte la SPA du dépôt `esthima-espace-client`, seulement pour un utilisateur connecté (sinon un lien de connexion). Deux modes, choisis par `ESTHIMA_SPA_DEV` :

- **Développement** : la page charge le serveur Vite de l'espace client, relayé par Apache sous `/react-dev/` (HTTP et WebSocket du rechargement à chaud). Dans `esthima-espace-client`, lancer `npm run mock` et `npm run dev:wordpress`, puis ici :
  ```bash
  ESTHIMA_SPA_DEV=1 docker compose up -d web
  ```
  L'amont du relais est `ESTHIMA_SPA_DEV_UPSTREAM` (`host.docker.internal:5173` par défaut). Un `docker compose up` ou `make run` sans la variable revient au mode build.
- **Build** : sans `ESTHIMA_SPA_DEV`, WordPress lit `manifest.json` sous `REACT_APP_CDN_URL` (le contenu de `dist/` après `npm run build:wordpress`) et charge l'entrée `wordpress`. Si `REACT_APP_CDN_URL` est vide ou si le manifeste est invalide, la page affiche « L'espace client ne peut pas être affiché pour le moment. ».

Pour rejouer les scénarios du chargeur (manifestes de test, visiteur connecté ou non, faux CDN, repli sur le dernier manifeste valide, message d'échec) ; le script sort en erreur au moindre écart, puis rend au service web la configuration de `.env` (relancer ensuite avec `ESTHIMA_SPA_DEV=1` si besoin) :
```bash
tests/spa/replay.sh
```
Variables facultatives : `BASE_URL` (`http://localhost`), `PAGE_PATH` (`/mon-espace`), `COMPOSE` (`docker compose`).

## Vérifier la session SSO

Avec le Docker lancé et la base importée, rejoue les scénarios SSO JWT (clé de test générée à l'exécution, service web redémarré avec une configuration SSO de test puis rendu à celle de `.env`) ; le script sort en erreur au moindre écart :
```bash
tests/sso/replay.sh
```
Variables facultatives : `BASE_URL` (`http://localhost`), `PAGE_PATH` (`/mon-espace`), `COMPOSE` (`docker compose`).

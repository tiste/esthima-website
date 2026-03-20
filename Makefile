#!make
include .env

.DEFAULT_GOAL := help
.PHONY: help
help:
	@echo "\033[33mUsage:\033[0m\n  make [target] [arg=\"val\"...]\n\n\033[33mTargets:\033[0m"
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' Makefile| sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-15s\033[0m %s\n", $$1, $$2}'

.PHONY: build
build: ## Build container images
	docker-compose build

.PHONY: run
run: ## Run builded containers
	docker-compose up -d

.PHONY: down
down: ## Stop and delete all container
	docker-compose down

.PHONY: stop
stop: ## Stop all container
	docker-compose stop

.PHONY: connect
connect: ## Open web CLI
	docker exec -it  web-$(NAME_PROJECT) /bin/bash

.PHONY: npmi
npmi: ## npm install
	docker exec -it  web-$(NAME_PROJECT) /bin/bash -c "cd wp-content/themes/${THEME_NAME} && npm i"

.PHONY: npmdev
npmdev: ## npm run dev
	docker exec -it  web-$(NAME_PROJECT) /bin/bash -c "cd wp-content/themes/${THEME_NAME} && npm run dev"

.PHONY: npmprod
npmprod: ## npm run prod
	docker exec -it  web-$(NAME_PROJECT) /bin/bash -c "cd wp-content/themes/${THEME_NAME} && npm run prod"

.PHONY: sshdb
sshdb: ## tunnel ssh db
	docker exec -it  web-$(NAME_PROJECT) /bin/bash -c "sudo apt-get update && sudo apt-get install autossh && autossh -M 0 -o 'ServerAliveInterval 30' -o 'ServerAliveCountMax 3' -N -L 3306:127.0.0.1:3306 -p ${SSH_PORT} ${SSH_USER}@${SSH_HOST}"

.PHONY: db
db: ## Install database
	docker exec -i mysql-$(NAME_PROJECT) mysql -uroot -f -p$(SQL_PASS) $(NAME_PROJECT) < db/dump.sql

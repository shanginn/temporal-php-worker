.PHONY : all help init up down install update build shell tests-worker

DC_RUN := docker compose run --rm --no-deps worker

all: help

init:
	cp .env.example .env
	$(DC_RUN) composer install

up:
	docker compose up -d

down:
	docker compose down

install:
	$(DC_RUN) composer install

update:
	$(DC_RUN) composer update

build:
	docker compose build

shell:
	docker compose exec worker bash

tests-worker:
	./tests/rr serve -c ./tests/.rr.yaml


fixcs: ## Run PHP CodeStyle fix
	$(DC_RUN) composer run fix-cs

phpstan: ## Run Static Analysis (PHPStan)
	$(DC_RUN) composer run phpstan

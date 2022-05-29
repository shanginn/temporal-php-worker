.PHONY : all help init up down install update build shell tests-worker

DC_RUN := docker-compose run --rm --no-deps worker

all: help

help: ## Show this help
	@printf "\033[33m%s:\033[0m\n" 'Available commands'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[32m%-14s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

init: ## Init application
	cp .env.example .env
	$(DC_RUN) composer install

up: ## Run containers
	docker-compose up -d

down: ## Stop containers
	docker-compose down

install: ## Run `composer install` inside the worker container
	$(DC_RUN) composer install

update: ## Run `composer update` inside the worker container
	$(DC_RUN) composer update

build: ## Build images
	docker-compose build

shell: ## Run bash inside working container
	docker-compose exec worker bash

tests-worker: ## WORK IN PROGRESS: Run tests
	./tests/rr serve -c ./tests/.rr.yaml

fixcs: ## Run PHP CodeStyle fix
	$(DC_RUN) composer run fix-cs

phpstan: ## Run Static Analysis (PHPStan)
	$(DC_RUN) composer run phpstan

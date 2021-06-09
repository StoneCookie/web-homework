LOCALHOST_PROJECT_DIR := $(bash pwd)

# IMPORT CONFIG WITH ENVS. You can change the default config with `make cnf="config_special.env" up-dev`
cnf ?= $(LOCALHOST_PROJECT_DIR)deploy/config.env
include $(cnf)

export $(shell sed 's/=.*//' $(cnf))

.DEFAULT_GOAL := help
# This will output the help for each task
# thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html

ifeq (some-cmd,$(firstword $(MAKECMDGOALS)))
  # use the rest as arguments for "run"
  RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  # ...and turn them into do-nothing targets
  $(eval $(RUN_ARGS):;@:)
endif

help:## This is help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.PHONY: help

echo-project-dir:## Show current working directory.
	@echo $(LOCALHOST_PROJECT_DIR)
	@echo $(PROJECT_NAME)

.PHONY: echo-project-dir

print:## print
	@echo %PATH%

.PHONY: print

## Docker compose shortcuts
up-dev print-compose-file: COMPOSE_FILE=docker-compose.yml
up-dev: ## Up current containers for dev
	docker-compose -f $(COMPOSE_FILE) up -d

print-compose-file:## print compose file
	@echo $(COMPOSE_FILE)

.PHONY: up-dev print-compose-file

stop-dev:## Stop current containers for dev
	docker stop ${PROJECT_NAME}-php &
	docker stop ${PROJECT_NAME}-nginx

.PHONY: stop-dev

delete-dev:## Delete dev container
	docker rm -f ${PROJECT_NAME}-php &
	docker rm -f ${PROJECT_NAME}-nginx

.PHONY: delete-dev

save-dev:## Saves dev files
	docker export ${PROJECT_NAME}-php | gzip > php.gz &
	docker export ${PROJECT_NAME}-nginx | gzip > nginx.gz

.PHONY: save-dev

php-exec: CMD?=-r 'phpinfo();'
php-exec: ## Run any php command in our container
	docker exec ${PROJECT_NAME}-php php $(CMD)

.PHONY: php-exec

some-cmd:
	docker run --name test --interactive --tty --volume $PWD:/app composer $(RUN_ARGS) &
	docker cp test:app $PWD &
	docker rm test &

.PHONY: some-cmd





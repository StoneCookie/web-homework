LOCALHOST_PROJECT_DIR := $(shell pwd "-"W)

# IMPORT CONFIG WITH ENVS. You can change the default config with `make cnf="config_special.env" up-dev`
cnf ?= $(LOCALHOST_PROJECT_DIR)/deploy/config.env
include $(cnf)

export $(shell sed 's/=.*//' $(cnf))

.DEFAULT_GOAL := help
# This will output the help for each task
# thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help:## This is help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.PHONY: help

echo-project-dir:## Show current working directory.
	@echo $(LOCALHOST_PROJECT_DIR)
	@echo $(PROJECT_NAME)

.PHONY: echo-project-dir

print:## print
	@printenv

.PHONY: print

## Docker compose shortcuts
up-dev print-compose-file test-HW6: COMPOSE_FILE=./docker-compose.yml
up-dev: ## Up current containers for dev
	docker-compose -f $(COMPOSE_FILE) up -d

stop-dev: ## Stop current containers for dev
	docker stop ${PROJECT_NAME}-php ${PROJECT_NAME}-nginx

kill-dev: ## Kill current containers for dev
	docker rm -f ${PROJECT_NAME}-php ${PROJECT_NAME}-nginx

save-dev: ## Save current containers for dev
	docker save ${CONTAINER_NAME}_php > ${CONTAINER_NAME}_php.tar
	docker save ${CONTAINER_NAME}_nginx > ${CONTAINER_NAME}_nginx.tar

print-compose-file:## print compose file
	@echo $(COMPOSE_FILE)

.PHONY: up-dev print-compose-file

php-exec: CMD?=-r 'phpinfo();'
php-exec: ## Run any php command in our container
	docker exec ${PROJECT_NAME}-php php $(CMD)

.PHONY: php-exec

ifeq (run-dev, $(firstword $(MAKECMDGOALS)))
  # use the rest as arguments for "run"
  RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  # ...and turn them into do-nothing targets
  $(eval $(RUN_ARGS):;@:)
endif

run-dev:
	winpty docker run --name test --interactive --tty composer $(RUN_ARGS)
	winpty docker cp test:app $(LOCALHOST_PROJECT_DIR)
	winpty docker rm test

get-token: USER?= admin
get-token: PASS?= qwerty
get-token:
	curl -X POST -H "Content-Type: application/json" http://project-symfony.local:8081/api/v1/test/login_check -d '{"username":"$(USER)","password":"$(PASS)"}'

login-token:
	curl -X GET http://project-symfony.local:8081/api/v1/test/users -H "Authorization: BEARER $(TOKEN)"
include .env.docker-compose

# Core Environment Commands
###########################

# Runs before every command to get the most recent configs
get_configs:
	cp -a .env.docker-compose ./scripts/makefile/config.sh

# Docker Commands
####################################################
clean: status
	./scripts/makefile/clean_docker_all.sh

clean_mysql:
	@echo 'Clean: MySQL'
	sudo chown -R ${DEVICE_HOST_USERNAME}:${DEVICE_HOST_USERNAME} volumes/data/mysql/storage/persist
	rm -Rf volumes/data/mysql/storage/persist/*

clean_docker:
	@echo 'Clean: Docker'
	./workflow.sh docker clean containers
	./workflow.sh docker clean images
	./workflow.sh docker clean all

status: get_configs
	./scripts/makefile/status.sh

boot: get_configs
	./scripts/makefile/boot.sh

boot_bg: get_configs
	./scripts/makefile/boot.sh silent

boot_clean: clean boot

boot_bg_clean: clean boot_bg



# Access Commands
####################################################
webapp_ssh:
	@echo 'SSH into the webapp container at /var/www/html'
	./workflow.sh access webapp


# Setup Commands
####################################################
webapp_setup:
	@echo 'Setup local webapp container for dev work.'
	./workflow.sh setup webapp

# Environment Commands
####################################################
fresh_install:
	@echo '==============================================='
	@echo 'Fresh Install of the Dev Environment for ${DEVICE_USER_FULL_NAME}.'
	@echo 'This is potentially DESTRUCTIVE for all your Projects under this environment.'
	@echo '==============================================='
	@echo 'Backing up'
	@echo '==============================================='
	@printf '\n'
	mkdir -p volumes/webapp_backup
	cp -a volumes/webapp/. volumes/webapp_backup/
	rm -rf volumes/workspace/*
	rm -rf devops
	touch volumes/workspace/.gitkeep
	@printf '\n'
	@echo '==============================================='
	@echo 'Environment: Fresh Install complete.'
	@echo '==============================================='
	@echo '${DEVICE_USER_FIRST_NAME}, you can now configure your env variables in .env.docker-compose'
	@printf '\n\n'

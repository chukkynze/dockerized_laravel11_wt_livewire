include .env.docker-compose

# Docker Commands
####################################################
clean:
	@echo 'Status: Docker'
	./workflow.sh docker status
	@echo 'Clean: MySQL and Docker'
	./workflow.sh docker clean containers
	./workflow.sh docker clean images
	./workflow.sh docker clean all

clean_mysql:
	@echo 'Clean: MySQL'
	rm -Rf volumes/data/mysql/storage/persist/*
	(cd volumes/data/mysql/storage/persist/ && find . ! -name '*.gitkeep' -type f -exec rm -f {} +)

clean_meilisearch:
	@echo 'Clean: Meilisearch'
	rm -Rf volumes/data/meilisearch/storage/persist/*

clean_docker:
	@echo 'Clean: Docker'
	./workflow.sh docker clean containers
	./workflow.sh docker clean images
	./workflow.sh docker clean all

status:
	./workflow.sh docker status

boot:
	@echo 'Bring Up Docker Environment'
	chmod ugo+x workflow.sh
	chmod 0444 ./volumes/data/mysql/config/mysql.cnf
	./workflow.sh docker config
	./workflow.sh docker up

boot_bg:
	@echo 'Bring Up Docker Environment Silently'
	chmod ugo+x workflow.sh
	chmod 0444 ./volumes/data/mysql/config/mysql.cnf
	./workflow.sh docker config
	./workflow.sh docker up-d

boot_clean: clean boot

boot_bg_clean: clean boot_bg


# Host Device Commands
####################################################
setup_rev_proxy:
	@echo 'Install and Setup Nginx on Host for Reverse Proxies'
	./workflow.sh tasks host setup_rev_proxy ${DEVICE_HOST_USERNAME} ${WEBAPP_NGINX_PORT}

test:
	@echo 'Testing Environment'
	./workflow.sh tasks test_env


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
	@echo 'This is potentially DESTRUCTIVE for all your Savi Projects under this environment.'
	@echo '==============================================='
	@printf '\n'
	@echo 'Install and Setup Nginx on Host for Reverse Proxies'
	./workflow.sh tasks host setup_rev_proxy ${DEVICE_HOST_USERNAME} ${EMP_ADMIN_WEB_NGINX_PORT}
	@echo '==============================================='
	@echo 'Backing up, then deleting the contents of the repositories folder except for the git and IDE files.'
	@echo '==============================================='
	@printf '\n'
	mkdir -p volumes/workspace_bkp
	cp -a volumes/workspace/. volumes/workspace_bkp/
	rm -rf volumes/workspace/*
	rm -rf devops
	touch volumes/workspace/.gitkeep
	@printf '\n'
	@echo '==============================================='
	@echo 'DevOps install.'
	@echo '==============================================='
	@printf '\n'
	#git clone git@bitbucket.org:teamsavi/devops.git devops
	#@chown -R ${DEVICE_HOST_USERNAME}:staff devops
	@printf '\n'
	@echo '==============================================='
	@echo 'Emp Admin App preparatory install.'
	@echo '==============================================='
	@printf '\n'
	mkdir -p volumes/workspace/projects/AppLaunchMay2024/EmployeeAdmin/web
	git clone git@bitbucket.org:ogeleiq/emp_admin_web.git volumes/workspace/projects/AppLaunchMay2024/EmployeeAdmin/web/.
	@printf '\n'
	@echo 'Copying backup git and idea folder if they exist'
	cp -a volumes/workspace_bkp/projects/AppLaunchMay2024/EmployeeAdmin/web/.git/. volumes/workspace/projects/AppLaunchMay2024/EmployeeAdmin/web/.git/  || true
	cp -a volumes/workspace_bkp/projects/AppLaunchMay2024/EmployeeAdmin/web/.idea/. volumes/workspace/projects/AppLaunchMay2024/EmployeeAdmin/web/.idea/  || true
	@echo 'Creating env files and using potentially existing backup'
	@printf '\n'
	cp volumes/workspace/projects/AppLaunchMay2024/EmployeeAdmin/web/.env.cubicle volumes/workspace/projects/AppLaunchMay2024/EmployeeAdmin/web/.env  || true
	cp volumes/workspace_bkp/projects/AppLaunchMay2024/EmployeeAdmin/web/.env volumes/workspace/projects/AppLaunchMay2024/EmployeeAdmin/web/.env  || true
	chown -R ${DEVICE_HOST_USERNAME}:staff volumes/workspace/projects/AppLaunchMay2024/EmployeeAdmin/web
	@printf '\n'
	@echo '==============================================='
	@echo 'Environment: Fresh Install complete.'
	@echo '==============================================='
	@echo '${DEVICE_USER_FIRST_NAME}, you can now configure your env variables in .env.docker-compose'
	@printf '\n\n'

# After all configs have been gathered
cbcl_setup:
	@echo 'Starting setup of properly configured repos'


cbcl_setup_all: cbcl_setup webapp_setup


# Task commands
####################################################

# todo: who's listening on what port: netstat -pna | grep 80

refresh_all:
	@echo 'Refresh Environment Data'
#	./workflow.sh setup all
#	./workflow.sh npm all
#	./workflow.sh cdn setup all
#	./workflow.sh permissions all
#	@echo 'Creating certs'
#	./workflow.sh certs create admin
#	./workflow.sh certs create client
#	./workflow.sh certs create pkg


## App
app_tail_all:
	@echo 'Tail All Logs'
	./workflow.sh tasks app tail_all

app_create_certs:
	@echo 'Create fake ssl certs'
	./workflow.sh tasks app certs_create

app_delete_certs:
	@echo 'Delete fake ssl certs'
	./workflow.sh tasks app certs_delete




## Git
app_prep_git:
	@echo 'Applying webapp git policy'
	cd volumes/workspace/projects/AppLaunchMay2024/EmployeeAdmin/web; \
    git config core.fileMode false


app_git_status:
	@echo 'Applying webapp git policy'
	cd volumes/workspace/projects/AppLaunchMay2024/EmployeeAdmin/web; \
    git status


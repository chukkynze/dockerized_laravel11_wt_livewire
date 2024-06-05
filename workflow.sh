#!/usr/bin/env bash

source ./shell/config.sh
source ./shell/general/os.sh
source ./shell/general/functions.sh

#########################################################
# Command Hierarchy
#
# Level $1
#   'docker' - Docker specific commands
#   'access' - Drop into a container using bash
#   'setup'  - Specific logic for setting up the environment
#   'task'   - Random One off tasks
#
#########################################################

# Parse Arguments
# e.g. bash workflow.sh tasks test_env
#
if [[ $# -gt 0 ]]; then

    if [[ "$1" == "docker" ]]; then

        if [[ "$2" == "config" ]]; then

            docker-compose --env-file="$DEFAULT_DOCKER_COMPOSE_ENV_FILE" config

        elif [[ "$2" == "up" ]]; then

            docker-compose --env-file="$DEFAULT_DOCKER_COMPOSE_ENV_FILE" up --force-recreate

        elif [[ "$2" == "up-d" ]]; then

            docker-compose --env-file="$DEFAULT_DOCKER_COMPOSE_ENV_FILE" up --force-recreate -d

        elif [[ "$2" == "clean" ]]; then

            if [[ "$3" == "all" ]]; then

                echo "Complete clean started..."
                docker-compose --env-file="$DEFAULT_DOCKER_COMPOSE_ENV_FILE" down \
                && docker system prune -f \
                && docker volume prune -f \
                && docker ps -a \
                && docker-compose --env-file="$DEFAULT_DOCKER_COMPOSE_ENV_FILE" ps \
                && (cd volumes/data/mysql/storage/persist/ && find . ! -name '*.gitkeep' -type f -exec rm -f {} +)

            elif [[ "$3" == "containers" ]]; then

                echo "Container cleaning started..."
                # shellcheck disable=SC2046
                docker rm $(docker ps -aq) -f
                docker ps -a

            elif [[ "$3" == "images" ]]; then

                echo "Image cleaning started..."
                # shellcheck disable=SC2046
                docker rmi $(docker images -aq) -f
                docker images -a

            fi

        elif [[ "$2" == "status" ]]; then

            # shellcheck disable=SC2046
            printf "\n"
            printf "============================================ \n"
            printf "Docker Environment Status \n"
            printf "============================================ \n"
            printf "\n"
            printf "Docker Volumes \n"
            printf "============================================ \n"
            docker volume ls || true
            printf "\n"
            printf "Docker Images \n"
            printf "============================================ \n"
            docker images -a || true
            printf "\n"
            printf "Docker Stats \n"
            printf "============================================ \n"
            docker ps -a || true
            printf "\n"
            printf "Docker Compose Stats \n"
            printf "============================================ \n"
            docker-compose --env-file="$DEFAULT_DOCKER_COMPOSE_ENV_FILE" ps || true
            printf "\n"
            printf "Docker Stats: System & Hard drive \n"
            printf "============================================ \n"
            docker system df || true
            printf "\n"
            printf "Docker Stats: CPU, Mem, Bandwidth \n"
            printf "============================================ \n"
            # shellcheck disable=SC2046
            docker stats --no-stream $(docker ps | awk '{if(NR>1) print $NF}') || true
            printf "\n"
            printf "Docker IPs: \n"
            printf "============================================ \n"
            # shellcheck disable=SC2046
            docker inspect -f '{{.Name}} - {{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' $(docker ps -aq) || true

        fi

    elif [[ "$1" == "access" ]]; then

        if [[ "$2" == "webapp" ]]; then

          docker exec -it -w /var/www/html webapp bash

        elif [[ "$2" == "redis" ]]; then

          docker exec -it redis redis-cli

        elif [[ "$2" == "mysql" ]]; then

          docker exec -it mysqldb mysql-cli

        fi

    elif [[ "$1" == "setup" ]];  then

        if [[ "$2" == "webapp" ]]; then

            # Remove project specific setup files from project
            rm -rfv "$ENVIRONMENT_ABS_FOLDER_PATH""$WEBAPP_REPO"/ecosystem/data/ || true
            rm -rfv "$ENVIRONMENT_ABS_FOLDER_PATH""$WEBAPP_REPO"/ecosystem/scripts/ || true

            # Copy new setup files from ecosystem to project
            cp -v -r "$ENVIRONMENT_ABS_FOLDER_PATH"/services/webapp/ecosystem/* "$ENVIRONMENT_ABS_FOLDER_PATH""$WEBAPP_REPO"/ecosystem

            # Set file permissions
            docker exec -it -w /var/www/html webapp chmod ugo+x ecosystem/scripts/setup.sh

            # Run setup scripts
            docker exec -it -w /var/www/html webapp bash ecosystem/scripts/setup.sh
            # docker exec -it -w /var/www/html webapp chmod ugo+x cubicle/scripts/setup_telescope.sh

        fi

    elif [[ "$1" == "tasks" ]];  then

          if [[ "$2" == "app" ]];  then

            if [[ "$3" == "tail_all" ]]; then

                docker exec -it -w /var/www/html webapp tail -f /var/log/nginx/error.log /var/log/nginx/access.log

            elif [[ "$3" == "certs_delete" ]]; then

                echo "Removing old certs for app"
                rm -Rf ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/*

            elif [[ "$3" == "certs_create" ]]; then

                echo ""
                echo "############################################"
                echo "Removing old certs for app"
                echo "############################################"
                rm -Rf ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/*

                ############################################
                # Create a key and certificate pair:
                ############################################

                echo ""
                echo "############################################"
                echo "Create a key and certificate pair"
                echo "############################################"
                sudo openssl req \
                  -x509 -nodes -days 365 -newkey rsa:2048 \
                  -subj "/CN=*.bysavi.dev" \
                  -config ~/webapp/cubicle/volumes/data/nginx/webapp/certs/config/v3.cnf \
                  -keyout ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/self-signed.key \
                  -out    ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/self-signed.crt

                echo ""
                echo "############################################"
                echo "Create a Diffie-Hellman Key Pair"
                echo "############################################"
                sudo openssl dhparam -out ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/dhparam.pem 128

                ############################################
                # Check if your cert and key match
                ############################################

                echo ""
                echo "############################################"
                echo "Check if your certificate and private key belong to each other"
                echo "############################################"
                openssl rsa  -noout -modulus -in ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/self-signed.key | openssl md5
                openssl x509 -noout -modulus -in ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/self-signed.crt | openssl md5

                echo ""
                echo "############################################"
                echo "Add the self-signed certificate to the trusted root store"
                echo "############################################"
                sudo security add-trusted-cert \
                  -d -r trustRoot \
                  -k /Library/Keychains/System.keychain ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/self-signed.crt

            elif [[ "$3" == "certs_create_old1" ]]; then

                echo ""
                echo "############################################"
                echo "Removing old certs for app"
                echo "############################################"
                rm -Rf ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/*

                ############################################
                # Become a Certificate Authority
                ############################################

                echo ""
                echo "############################################"
                echo "Generate private key"
                echo "############################################"
                #openssl genrsa -des3 \
                openssl genrsa \
                -out ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/ssl.key 2048

                echo ""
                echo "############################################"
                echo "Generate root certificate"
                echo "############################################"
                openssl req -x509 -new -nodes \
                -key ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/ssl.key \
                -sha256 \
                -days 1000 \
                -subj "/C=US/ST=CA/L=LA/O=Savi LLC - Employee/OU=Dev Team/CN=Savi LLC - Employee/emailAddress=ssl@bysavi.dev" \
                -out ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/ssl.pem

                ############################################
                # Create CA-signed certs
                ############################################

                echo ""
                echo "############################################"
                echo "Create a certificate-signing request"
                echo "############################################"
                openssl req -new -sha256 -nodes \
                -out ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/ssl.csr \
                -newkey rsa:2048 \
                -subj "/C=US/ST=CA/L=LA/O=Savi LLC - Employee/OU=Dev Team/CN=Savi LLC - Employee/emailAddress=ssl@bysavi.dev" \
                -keyout ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/ssl.key

                echo ""
                echo "############################################"
                echo "Check if your certificate and private key belong to each other"
                echo "############################################"
                openssl rsa  -noout -modulus -in ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/ssl.key | openssl md5
                openssl req  -noout -modulus -in ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/ssl.csr | openssl md5
                openssl x509 -noout -modulus -in ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/ssl.crt | openssl md5

                echo ""
                echo "############################################"
                echo "Create the signed certificate"
                echo "############################################"
                openssl x509 -req \
                -in ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/ssl.csr \
                -CA ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/ssl.pem \
                -CAkey ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/ssl.key \
                -CAcreateserial \
                -out ~/webapp/cubicle/volumes/data/nginx/webapp/certs/actual/ssl.crt \
                -days 1000 -sha256 \
                -extfile ~/webapp/cubicle/volumes/data/nginx/webapp/certs/config/v3.ext

            fi

        elif [[ "$2" == "host" ]]; then

            if [[ "$3" == "setup_rev_proxy" ]]; then

                printf "\n"
                echo "======================================================="
                echo "Installing and Setting up Nginx on Host for Reverse Proxies"
                echo "======================================================="
                printf "\n"

                if [[ "$(uname)" == "Darwin" ]]; then

                    # Do something under Mac OS X platform
                    #########################################################
                    echo "You are working on a Mac host machine"
                    echo "It is expected that you have Xcode and Homebrew installed."
                    printf "\n"
                    echo "Brew: Installing Nginx."
                    echo "----------------------------------------"
                    brew --version
                    brew analytics off
                    brew install nginx
                    nginx -v
                    nginx -t
                    printf "\n"
                    echo "Configuring Nginx."
                    echo "----------------------------------------"
                    mkdir -p /home/academystack/PhpstormProjects/work/OgeleIQ/IoT/academystack/technology/ecosystem/docker/environment/v0_2024_03_16/logs/academystack.test || true
                    cp -a stubs/rev_proxy_nginx.conf.stub /etc/nginx/nginx_academystack.conf
                    sed -i -e "s/{{DEVICE_HOST_USERNAME}}/$4/g" /etc/nginx/nginx_academystack.conf
                    sed -i -e "s/{{APP_BY_SAVI_WEB_NGINX_PORT}}/$5/g" /etc/nginx/nginx_academystack.conf
                    printf "\n"
                    echo "Brew: Restarting Nginx."
                    echo "----------------------------------------"
                    nginx -t
                    brew services restart nginx
                    printf "\n"

                elif [[ "$(expr substr "$(uname -s)" 1 5)" == "Linux" ]]; then

                    # Do something under GNU/Linux platform
                    #########################################################
                    echo "You are working on a Linux host machine"
                    printf "\n"

                fi

            fi

        elif [[ "$2" == "test_env" ]]; then

            echo Welcome user ${USERNAME} with email: ${EMAIL}.
            echo You are currently working in "$(get_current_os)".

            printf "\n"
            echo "======================================================="
            echo "Let's make sure the environment is what we expect it to be"
            echo "======================================================="
            printf "\n"
            printf "===============================\n"
            printf "= Configs\n"
            printf "===============================\n"
            printf "CURRENT_OS = "
            get_current_os
            printf "CURRENT_OS_FLAVOR = "
            get_current_os_flavor
            printf "CURRENT_OS_FLAVOR_BIT = "
            get_current_os_flavor_bit
            printf "CURRENT_OS_FLAVOR_VERSION = "
            get_current_os_flavor_version
            printf "\n"
            printf "===============================\n"
            printf "= Next\n"
            printf "===============================\n"
            printf "thing = "
            printf "\n\n"

        fi

    fi

else
  echo "The following top level arguments are valid: docker, access, setup, task"
fi
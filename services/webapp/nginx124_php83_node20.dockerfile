FROM phusion/baseimage:jammy-1.0.2

MAINTAINER Chukwuma J. Nze

RUN apt-get update                  \
    && apt-get install -y locales   \
    && locale-gen en_US.UTF-8

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8
ENV LC_CTYPE=en_US.UTF-8
ENV TERM xterm

ENV DEBIAN_FRONTEND=noninteractive

ARG XDEBUG_HOST_IP
ARG GIT_USERNAME
ARG GIT_EMAIL

RUN apt-get update                                  \
    && apt-get install -y gnupg tzdata              \
    && echo "UTC" > /etc/timezone                   \
    && dpkg-reconfigure -f noninteractive tzdata

RUN apt-get update                      \
    && apt-get -o Dpkg::Options::=--force-confdef -o Dpkg::Options::=--force-confold upgrade -yq \
    && apt-get install -y --allow-downgrades --allow-remove-essential --allow-change-held-packages \
       acl                              \
       apt-transport-https              \
       apt-utils                        \
       ca-certificates                  \
       chromium-browser                 \
       curl                             \
       git                              \
       gpg                              \
       gtk2-engines-pixbuf              \
       htop                             \
       inetutils-ping                   \
       mysql-client                     \
       nano                             \
       nginx                            \
       pkg-config                       \
       supervisor                       \
       software-properties-common       \
       unzip                            \
       vim                              \
       wget                             \
       x11-apps                         \
       xdg-utils                        \
       xfonts-75dpi                     \
       xfonts-100dpi                    \
       xfonts-base                      \
       xfonts-cyrillic                  \
       xfonts-scalable                  \
       xvfb                             \
       zip                              \
    && add-apt-repository -y ppa:ondrej/php \
    && apt-get update       \
    && apt-get install -y --allow-downgrades --allow-remove-essential --allow-change-held-packages \
       libgconf-2-4         \
       libgtk2.0-0          \
       libnss3              \
       libxpm4              \
       libxrender1          \
    && apt-get update \
    && apt-get install -y --allow-downgrades --allow-remove-essential --allow-change-held-packages \
       libonig-dev              \
       libcurl4-openssl-dev     \
       libedit-dev              \
       libhiredis-dev           \
       libssl-dev               \
       libxml2-dev              \
       libzip-dev \
    && apt-get update \
    && apt-get install -y --allow-downgrades --allow-remove-essential --allow-change-held-packages \
       php8.3           \
       php8.3-bcmath    \
       php8.3-cli       \
       php8.3-common    \
       php8.3-curl      \
       php8.3-dev       \
       php8.3-fpm       \
       php8.3-gd        \
       php8.3-http      \
       php8.3-imap      \
       php8.3-intl      \
       php-json      \
       php8.3-mbstring  \
       php8.3-mongodb   \
       php8.3-mysql     \
       php8.3-opcache  \
       php8.3-pdo       \
       php8.3-raphf     \
       php8.3-readline  \
       php8.3-redis     \
       php8.3-soap      \
       php8.3-sqlite3   \
       php8.3-xdebug    \
       php8.3-xml       \
       php8.3-zip       \
       php-igbinary     \
       php-imagick      \
       php-msgpack      \
       php-redis        \
    && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && mkdir /run/php                                           \
    && apt-get remove -y --purge software-properties-common     \
    && apt-get -y autoremove                                    \
    && apt-get clean                                            \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*            \
    && ln -sf /dev/stdout /var/log/nginx/access.log             \
    && ln -sf /dev/stderr /var/log/nginx/error.log

RUN update-alternatives --set php /usr/bin/php8.3
#RUN pecl install swoole

COPY default.conf                                           /etc/nginx/sites-available/default
COPY nginx.conf                                             /etc/nginx/nginx.conf
COPY php-cli.ini                                            /etc/php/8.3/cli/php.ini
COPY php-fpm.ini                                            /etc/php/8.3/fpm/php.ini
COPY supervisord.conf                                       /etc/supervisor/supervisord.conf
COPY www.conf                                               /etc/php/8.3/fpm/pool.d/www.conf
COPY xdebug3.ini                                            /etc/php/8.3/mods-available/xdebug.ini
COPY aliases.bashrc                                         /root/aliases.bashrc

RUN cat /root/aliases.bashrc >> /root/.bashrc

RUN git config --global user.name $GIT_USERNAME   \
    && git config --global user.email $GIT_EMAIL  \
    && mkdir -p /etc/nginx/certs                  \
    && mkdir -p /var/www/html/storage/logs

RUN set -xe; \
    groupadd -g 1000 chukkynze && \
    useradd -u 1000 -g chukkynze -m chukkynze -G docker_env

RUN echo "chukkynze ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

RUN chown -R www-data:www-data /var/www/html

## Install Node 20 and NPM
RUN curl -sL https://deb.nodesource.com/setup_20.x -o nodesource_setup.sh
RUN bash nodesource_setup.sh
RUN apt remove -y nodejs npm
RUN apt install -y nodejs
RUN npm install -g npm@10.5.0
RUN chown -R 33:33 "/root/.npm"

ENV PATH $PATH:/nodejs/bin

EXPOSE 80 443

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
FROM ghcr.io/quadrubo/php-fpm-alpine-s6-nginx:php8.2-alpine3.18 as waky_builder

# Install node
ENV NODE_VERSION=18.16.0

ENV NODE_PACKAGE_URL=https://unofficial-builds.nodejs.org/download/release/v$NODE_VERSION/node-v$NODE_VERSION-linux-x64-musl.tar.xz

RUN apk update && \
    apk add --no-cache libstdc++

RUN curl -fsSLO --compressed $NODE_PACKAGE_URL \
    && tar -xJf "node-v$NODE_VERSION-linux-x64-musl.tar.xz" -C /usr/local --strip-components=1 --no-same-owner \
    && ln -s /usr/local/bin/node /usr/local/bin/nodejs \
    # fi
    && rm -f "node-v$NODE_VERSION-linux-x64-musl.tar.xz" \
    # smoke tests
    && node --version \
    && npm --version

WORKDIR /var/www/html

# Copy app
COPY --chown=webuser:webgroup . /var/www/html/

# Install composer dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-cache \
    && mkdir -p storage/logs \
    && php artisan optimize:clear \
    && chown -R webuser:webgroup /var/www/html

# Install npm dependencies
RUN npm pkg delete scripts.prepare
RUN npm ci \
    && npm run build \
    # Clean up
    && npm cache clean --force \
    && rm -rf node_modules

# main image
FROM ghcr.io/quadrubo/php-fpm-alpine-s6-nginx:php8.2-alpine3.18

# Add /config to allowed directory tree
ENV PHP_OPEN_BASEDIR=$WEBUSER_HOME:/config/:/dev/stdout:/tmp

# Enable mixed ssl mode so port 80 or 443 can be used
ENV SSL_MODE="mixed"

# Install additional packages and cron file
RUN apk update \
    && apk add --no-cache \
        curl \
        # cron \
        iputils-ping \
        openssh-client \
        # Needed for envsubst
        gettext \
    # Install cron file
    && echo "MAILTO=\"\"\n* * * * * webuser /usr/bin/php /var/www/html/artisan schedule:run" > /var/spool/cron/crontabs/root \
    # Clean up package lists
    # && apt-get clean \
    && rm -rf /tmp/* /var/tmp/* /usr/share/doc/*

# Copy package configs
COPY --chmod=755 docker/deploy/etc/s6-overlay/ /etc/s6-overlay/

WORKDIR /var/www/html

# Copy app
COPY --from=waky_builder --chown=webuser:webgroup /var/www/html /var/www/html/

VOLUME /config
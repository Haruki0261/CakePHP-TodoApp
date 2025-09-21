FROM php:8.3-fpm

RUN apt-get update && \
	apt-get install -y git unzip libicu-dev libonig-dev && \
	docker-php-ext-install intl pdo_mysql
		
COPY ./php.ini /usr/local/etc/php/php.ini

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /app

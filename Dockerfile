FROM php:8.2-apache

WORKDIR /mybank

COPY composer.json /mybank

COPY . /mybank

ENV DATABASE_URL=mysql://root:@mysql:3306/symfony_api?serverVersion=8.0.32&charset=utf8mb4

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update -qq && apt-get install -y unzip git curl zip && curl -sS https://getcomposer.org/installer | php && php composer.phar install

CMD ["./commands.sh"]

EXPOSE 8000
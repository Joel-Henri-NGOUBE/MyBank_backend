FROM php:8.2-apache

WORKDIR /mybank

COPY composer.json /mybank

COPY . /mybank

# ENV DATABASE_URL=mysql://root:@localhost:3306/symfony_api?serverVersion=8.0.32&charset=utf8mb4
# ENV DATABASE_URL=mysql://root:@database:3306/symfony_api?serverVersion=8.0.32&charset=utf8mb4
ENV DATABASE_URL=mysql://root:@mysql:3306/symfony_api?serverVersion=8.0.32&charset=utf8mb4

# ENV DB_HOST=database

# ENV DATABASE_URL=mysql://root:@0.0.0.0:3306/symfony-tutorial?serverVersion=8.0.32&charset=utf8mb4

# RUN apt-get update

# RUN apt-get install bash

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update -qq && apt-get install -y unzip git curl bash zip && curl -sS https://getcomposer.org/installer | php && php composer.phar install

# RUN bash

# RUN php bin/console doctrine:database:create

# RUN php bin/console make:migration

# RUN php bin/console doctrine:migrations:migrate

# CMD ["php", "bin/console", "doctrine:database:create"]

CMD ["./commands.sh"]

# CMD ["php", "bin/console", "doctrine:migrations:migrate"]

# CMD ["php", "bin/console", "doctrine:database:create"]

# CMD ["php", "bin/console", "doctrine:database:create ; php bin/console make:migration ; php bin/console doctrine:migrations:migrate ; php -S 0.0.0.0:8000 -t public"]

# CMD ["php", "bin/console", "doctrine:database:create", "php", "bin/console", "make:migration", "php", "bin/console", "doctrine:migrations:migrate", "php", "-S", "0.0.0.0:8000", "-t", "public"]
# CMD ["php", "bin/console doctrine:database:create && php bin/console make:migration && php bin/console doctrine:migrations:migrate && php -S 0.0.0.0:8000 -t public"]

# CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]

EXPOSE 8000
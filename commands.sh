sleep 120;
php bin/console lexik:jwt:generate-keypair
while true; do php bin/console make:migration && break; done
while true; do php bin/console doctrine:migrations:migrate -n && break; done
php -S 0.0.0.0:8000 -t public



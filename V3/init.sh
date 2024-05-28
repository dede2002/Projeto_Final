#!/bin/bash

# Esperar 15 segundos para o MySQL iniciar
sleep 15

# Iniciar o Apache em primeiro plano
apache2-foreground &

# Mudar para o diretório do Laravel
cd /var/www/html

# Copiar a .env.example para .env se não existir
if [ ! -f .env ]; then
  cp .env.example .env
fi


# Definir permissões apropriadas para o diretório de armazenamento e cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Gere a chave da aplicação Laravel
php artisan key:generate

# Executar as migrações do Laravel
php artisan migrate

# Executar os seeders do Laravel
php artisan db:seed

# Executar o npm run dev
npm run dev &

# Manter o contêiner em execução
tail -f /dev/null

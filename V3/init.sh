
# Esperar 10 segundos
sleep 15

# Iniciar o Apache em primeiro plano
apache2-foreground &

# Mudar para o diretório do Laravel
cd /var/www/html

# copiar a .env.example para .env
cp .env.example .env

# Gere a chave da aplicação Laravel
php artisan key:generate

# Executar as migrações do Laravel
php artisan migrate

php artisan db:seed

npm run dev &

# Mantenha o contêiner em execução
tail -f /dev/null
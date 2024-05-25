# Olá grupo, aqui vou ensinar como fazer o programa de clinica funcionar no seu computador!


Você, pequeno gafanhoto, deverá ter os seguintes softwares instalados em seu computador:
# Parte 1 -> baixando e configurando softwares necessários
## PHP: 
- Você deverá baixar a partir desse link: https://windows.php.net/downloads/releases/php-8.3.7-Win32-vs16-x86.zip
- Após esse feito, você deve descompacta-lo e configura-lo como variavel de sistema, para isto, siga as instruções
- Dica: não extraia em downloads | Crie uma pasta nova, vazia e extraia nela
  - busque "editar as variaveis de ambiente do sistema" na barra de pesquisa do seu computador. (o nome pode variar dependendo da versão do windows)
  - clique em "variáveis de ambiente"
  - Selecione "PATH" na aba de baixo (variaveis de sistema e não variaveis de usuário)  -> "Editar"
  - Selecione a pasta em "Procurar" (com todos os arquivos extraidos PHP), selecione a pasta que você descompactou os arquivos PHP
  - Clique em "Adicionar" -> "Ok", pode fechar a janela
 
- Depois, abra o arquivo na pasta descompactada "php.ini" e descomente (retire o ";" de antes da linha) dos seguintes comandos
  - extension=fileinfo
  - extension=pdo_mysql
- Para veririficar a instalação, rode o comando
```
php -v
```

## Composer:
- Baixe-o daqui: https://getcomposer.org/Composer-Setup.exe
- Baixe-o apenas clicando em next, não altere as opções
- Ele deve buscar a configuração PHP automaticamente, porém caso isso não ocorra, insira o caminho até o arquivo "php.exe"

## MYSQL (banco de dados)
- Baixe o mysqlInstaller aqui: https://dev.mysql.com/get/Downloads/MySQLInstaller/mysql-installer-web-community-8.0.37.0.msi
- Durante a configuração, utilize a senha 'root'
- Após terminar a instalação, abra o instalador novamente e clique em "add"
- Navegue em 'ADD' -> '+Applications' -> '+MySQL Workbench' -> MySQL Workbench 8.0.34 X64
- Selecione esta opção, clique na seta verde e inicie a instalação.
- Abra o workbench, acesse so banco de dados com a senha
  - Na sessão esquerda, na seção inferior da aba navigator a opção "Administration" vem selecionada por padrão, clique em -> Schemas
  - Na aba de Query ( o quadro branco logo a direita ) insira o seguinte comando:
```
create database laravel
```
  - Logo depois clique o ícone de raio na parte superior para executar a ação | A linha que você escreveu o comando deve estar selecionada

# Parte 2 -> Configurando o aplicativo
## Configurando os arquivos
Antes de tudo, abra a pasta do example-appV12 no vscode e criem um terminal para ela. Rode o seguinte comando
```
cp .env.example .env
```
Agora no arquivo .env deixe a configuração do mysql do seguinte modo:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```

## Configurando os frameworks

- Você vai precisar de 2 terminais para rodar
- Primeiro, vamos configurar o laravel:
```
composer require laravel/breeze --dev

php artisan migrate
```
- Em um segundo terminal, rode os seguintes comandos:
```
npm install

npm run dev
```
- Voltando no primeiro terminal (PHP)
  - Se der erro no RoleSeeder pode ignora-lo
```
php artisan key:generate

php artisan db:seed RoleSeeder

php artisan serve
```

Depois disso, vai estar na aba: localhost:8000

# Parte 3 -> Configurando usuários
## Criando um usuário

No final da página (rodapé) Você encontrará o botão de 'registrar'. Clique nele e crie seu usuário
Após criar o usuário, você será apresentado com uma página de erro, ISSO É NORMAL, ESTA NÂO SERÁ A VERSÂO QUE ENTREGAREMOS AO XASTRE
- Agora, navegue para sua tabela no mysql, no schema laravel e abra a table users
  - Na última coluna da table, a coluna "role", mude o valor do usuário que você acabou de criar para "secretaria"
  - Retorne e acesse "localhost:800/Secretaria/dashboard"

 ## adicionando usuários como secretaria
 - No dashboard da secretaria, utilize o botão "adicionar usuário" para criar qualquer tipo de usuário
 - Depois disso, você pode fazer logout e entrar com o usuário que você acabou de criar, sendo redirecionado automaticamente para o dashboard referente ao seu papel na clinica

# É nois rapazeada, GG

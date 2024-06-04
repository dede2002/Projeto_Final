# Sobre o Projeto
Esse projeto teve o objetivo de criar um sistema para uma clínica de psicólogos, e aprimorar conceitos aprendidos em Banco de Dados e App.

# Tecnologias Utilizadas no Projeto
- Visual Studio Code: ambiente para realizar os códigos do projeto
- Laravel: back e front end
- VueJs: dentro do Laravel para o front
- Docker: utilização de containers
- Docker Swarm: adiministrar os containers
- MySql: banco de dados
- ElectronJs: criar um app para Windows
- Trello: planejamento do projeto

# Integrando o docker em nosso projeto

Ao baixar o projeto, abra a pasta "V3" no terminal

Nela, digite o seguinte comando:

```
docker-compose up --build
```

Neste ponto você já consegue acessar o programa em: http://localhost:8000

Para parar os container, digite ctrl + c

Depois de rodar o comando acima pela primeira vez, pode subir os containers apenas com
```
docker-compose up -d
```

## Você pode fazer login como secretária com as seguintes credenciais:

```
E-Mail: secretaria@secretaria.com
Senha: 123456789
```

## Acessando o banco de dados

No MySQL Workbench, cria uma nova conexão com a porta 3308, ela estará lá

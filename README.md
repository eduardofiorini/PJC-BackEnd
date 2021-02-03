# PJC BackEnd
Projeto desenvolvido para o seletivo do PJC MT, para cargo de desenvolvedor BackEnd.

### Desenvolvedor
* Autor: Eduardo Fiorini
* E-mail: <edupva@gmail.com>

## Introdução
A tecnologia escolhida para o desenvolvimento da api, foi o PHP 7 com Framework Codeigniter 4 e base de dados MySql.

## Documentação da API
A documentação foi gerada usando o PostMan e está disponível no link abaixo.
* <https://documenter.getpostman.com/view/3352628/TW71kmFZ>
## Passo a Passo - Iniciar o Serviço Manualmente
1. É necessário possuir o PHP 7.2 ou superior e o MySql instalado na maquina local, caso não tenha pode ser baixado Wamp ou Xampp.
1. Efetue o download completo do projeto a partir do link abaixo e descompacte ou clone esse diretório a partir do git.
    * <https://github.com/eduardofiorini/PJC-BackEnd/archive/main.zip>
1. Abra o seu MySql e crie um novo banco de dados limpo, vá na pasta do sistema e abra o arquivo `.env` para que possamos definir as conexões com o banco de dados.
    ```
        database.default.hostname = localhost
        database.default.database = pjc
        database.default.username = root
        database.default.password =
        database.default.DBDriver = MySQLi
    ```
1. Após configurarmos o nosso arquivo `.env`, na pasta raiz do projeto abra o terminal CMD e execute os seguintes comandos abaixo, apenas um por vez.
    ```
        php spark migrate
        php spark db:seed ArtistaSeeder
        php spark db:seed AlbumSeeder
        php spark db:seed AuthSeeder
        php spark db:seed ImagemSeeder
        php spark serve
    ```
1. Pronto, a aplicação já criou as tabelas, já inseriu os dados iniciais e já iniciou a aplicação em http://localhost:8080/
1. Agora basta seguir a documentação e efetuar os testes na API. 
## Implementações
As prioridades estão listadas abaixo na ordem crescente, foi priorizado desta maneira seguindo o fluxo de um projeto MVC.   
- [X] Criação do README;
- [X] Add Framework CodeIgniter 4;
- [X] Implementar Migrations;
- [X] Implementar Models;
- [X] Implementar JWT;
- [X] Implementar Validações;
- [X] Implementar Limitar Request (AntiDdos);
- [X] Implementar Limitar Acesso Externo;
- [X] Implementar Controllers;
- [X] Implementar Rotas;
- [X] Implementar Paginação;
- [X] Implementar Ordenação;
- [X] Implementar Upload MinIO;
- [ ] Dockerizar Aplicação;

- As dificuldades encontradas foram na parte da utilização do docker, como nunca usei esse recurso não consegui implementa-lo ao projeto.
## Créditos
1. CodeIgniter
    - <https://codeigniter.com/>
1. Firebase/php-jwt
    - <https://github.com/firebase/php-jwt>
1. Composer
    - <https://getcomposer.org/>
1. Packagist
    - <https://packagist.org/>
1. MySQL
    - <https://www.mysql.com/>
1. MinIO
    - <https://min.io/>
1. PostMan
    - <https://www.postman.com/>
1. Docker 
    - <https://www.docker.com/>

## Referências
* <http://www.pjc.mt.gov.br/>
* <https://jwt.io/introduction>
* <https://docs.min.io/>
* <https://github.com/firebase/php-jwt>
* <https://codeigniter.com/user_guide/index.html>
* <https://packagist.org/packages/firebase/php-jwt>
* <https://drive.google.com/file/d/122ulw68Ez_tmXq_2wex3AetN5cpH4g0c/view>


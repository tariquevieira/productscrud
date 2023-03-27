# Sistema venda de produtos
Esse é o banckend de sistema de produtos e categorias(tipos de produtos) em bancos SQL

## Overview do Código
O codigo está segmentado em diferentes dirtórios para facilitar validação. Por exemplo:
- Rotas em um unico arquivo na pasta de *routes*.
- Configuração de banco de dados na pasta *database*
- Arquivos de configuração e inicialização de sistema estão pasta *config*
- Arquivos publicos e ponto de acesso ao sistema na pasta *public*
- Todo código de regra de negócio e tratamento de requisião na pasta *scr* divididos também por modulos
- Testes unitários na pasta de *tests*

## Execução
Para executar o programaserá necessário rodar:
- *php -S localhost:8080 -t public/*  
  
### Configuração de banco de dados

Toda configuração acesso ao banco de dados deverá ser feito pelo arquivo .env na raíz do projeto.
- A variável de DB_SERVER deve informar qual modulo do banco de dados. Por exemplo: *pgsql* para postgres.
- O backup do banco de dados esta na raíz do projeto com extensão .bkp

### Variáveis de rotas
As rotas de find, update e delete necessitam passar variavel code na url, como por exemplo:
- http://localhost:8080/category/find?code=10
- http://localhost:8000/product/update?code=266
  
### Métodos http
Para desenvolvimento desse projeto foram utilizado apenas metodos nativos GET e POST:
Rotas que usam o metodo **GET**:
- product/
- category/
- product/find
- category/find

Rotas que usam o metodo **POST**:
- /category/store 
- /category/delete
- /category/update
- /product/store
- /product/delete
- /product/update

### Padrão de request e response
As request de formulário deverão ser no padrão *multipart-form*. As respostas serão no formato json.

#### Teste unitário
Os testes poderão ser executados com:
- ./vendor/bin/phpunit [path] --colors

### Arquivo de configuração
Arquivo de configuração .env.example contém todas variáveis de ambientes que são serão usadas para mensagens de sistema, configuração de banco de dados e quaisquer outras configurações em que projeto vier necessitar:
- DB_SERVER: define qual banco de dados será usado, por exemplo: mysql e pgsql.
- DB_HOST: endereço ip do servidor de banco de dados, caso seja ambiente local basta usar *localhost*
- DB_DATABASE: nome do banco de dados que será usado.
- DB_USER: nome do usuário.
- DB_PASSWORD: senha do ususário.
- MSG_PRODUCT_NOTFOUND="Produto não encontrado": mensagem a ser exibida caso produto não seja encontrado.

#### Desenvolvido por:
- Tarique Vieira Ramos
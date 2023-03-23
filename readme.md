# Sistema de Controle de produtos
Esse é o banckend de sistema de produtos e categorias(tipos de produtos) em bancos SQL

## Estado atual da aplicação

Para execução do projeto modelei a tabela de produtos separada do tipo de produto.
Não consegui finalizar o CRUD referente ao produto até a presente finalização deste documento.

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

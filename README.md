## API Encurtador

Requisitos funcionais

-   Dada uma URL, a API deverá retornar sua versão encurtada. O tamanho da URL
    encurtada deve ser o menor possível
    Exemplo: http://www.uol.com.br/noticias/abc.html -> http://m2b.io/Kz78m
-   Quando uma URL encurtada for acessada no browser, deve ser realizado um
    redirecionamento para a URL completa
-   API permitirá que o cliente escolha (caso deseje e esteja disponível) o nome da URL
    encurtada
    Exemplo: http://www.uol.com.br/noticias/abc.html -> http://m2b.io/noticia-abc
-   As URLs encurtadas possuem um tempo de expiração padrão (7 dias) e devem ser
    desativadas após o mesmo. Nesse caso, ao acessar uma URL expirada o sistema deve
    retornar HTTP 404 (not found)

Requisitos não-funcionais

-   O redirecionamento da URL encurtada para a completa deve ser o mais eficiente possível
-   A URL encurtada deve ser randômica o suficiente, evitando ser “descoberta” facilmente

Implementação

-   A API deve possuir 2 endpoints:

1. Criação de URL encurtada
   Parâmetros:

-   URL original
-   URL encurtada desejada (opcional, padrão é randômico)
-   Data de expiração (opcional, padrão é expirar em 7 dias)
    Retorno (JSON):
-   URL encurtada

2. URL encurtada
   Não recebe parâmetros, apenas redireciona para a URL original

-   A API deve ser implementada na linguagem que for mais confortável ao candidato
-   A API não precisa de autenticação ou autorização, pois será de um serviço público
-   As URLs devem ser duráveis e persistidas em uma base de dados, seja essa SQL, NoSQL
    ou similar
-   As URLs expiradas devem ser removidas da base de dados.

## Tecnologia Utilizada

A api foi desenvolvida com a linguagem php utilizando o framework Lumen

## Instalação

### Acesse o diretorio raiz do projeto para iniciar a configuração e instalação

#### 1 - Crie o arquivo .env e configure o banco de dados

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=encurtador
DB_USERNAME=encurtador
DB_PASSWORD=senha_do_banco
```

#### 2 - A aplicação utiliza um sistema de cache, para configurar preencha as informações no arquivo .env . Para fins de testes foi utilizado o driver de cache padrão "file"

```
CACHE_DRIVER=file
```

#### 3 - Instalação das dependencias

```
composer install
```

#### 4 - Gere uma chave privada para ser utilizada nos tokens de autenticação

```
php artisan jwt:secret
```

#### 5 - Execute as migrations

```
php artisan migrate --seed
```

#### 6 - Usuário teste da aplicação foi gerardo com o comando acima

```
Usuário padrão: admin@admin.com
Senha: admin
```

#### 7 - Testando a aplicação

```
php -S localhost:9000 -t ./public
```

#### 8 - Rotas

```
POST: http://localhost:9000 - Cria uma nova url
GET: http://localhost:9000/{url} - Acessar uma url encurtada
POST: http://localhost:9000/login - Gera um token para acessar as urls encurtadas
GET: http://localhost:9000 - Lista todas as urls encurtadas
```

#### 9 - Para verificar as urls expiradas, existe um job que pode ser programado para ser executado a qualquer tempo

```
Dentro da pasta do projeto execute:

php artisan schedule:run

Ou utilize algum serviço de monitoramento de processos para executar automaticamente o comando acima
```

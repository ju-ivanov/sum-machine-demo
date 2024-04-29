# Sum Machine

## Description

This is simple demo project written in just a few hours. You can sum integer numbers via REST API and then get the result. Crazy thing. :)

The project provides infrastructure for local deployment & development.

## Technical stack

- PHP 8.2
- Laravel 10
- PostgreSQL
- Doctrine
- PHPUnit
- Docker / Docker Compose

## Implemented code scanners

- PHPStan
- Rector
- PHP CS Fixer
- PHP Code Sniffer
- PHP Security Checker
- PHP Mess Detector
- PHP Lint
- PHP Magic Number Detector
- VAR_DUMP Checker
- Composer Require Checker
- Composer Unused Dependencies Checker

## REST API

API uses standard `data/error` response format.

    POST /api/token

Generates a new sum machine token. You will receive token value in the response (token has UUID4 format):

```json5
{
    "data" : {
        "token" : "f1e750a1-c04f-40a6-b822-b66ca3735a50"    
    },
}
```

You should add this token value as `Token` header in every single request described below, otherwise you will get an error.

----

    POST /api/number

Adds a new number into the stack specified by token. Request params:

    {
        "number": 45 // the number you want to add into stack
    }

You will receive the renewed amount of elements in the stack:

```json5
{
    "data" : {
        "count": 5
    }
}
```

----

    DELETE /api/number

Removes the last added number from the stack. You will receive the renewed amount of elements in the stack:

```json5
{
    "data" : {
        "count": 4
    }
}
```

If the stack doesn't contain any element already, you will get an error.

----

    GET /api/sum

Yabba-dabba-doo! Returns the sum of all numbers in the stack:

```json5
{
    "data" : {
        "sum": 123
    }
}
```

## Local deployment & development

You should have locally installed Docker and Docker Compose applications.

Build & run the microservice:

    sh init.sh # (or bash init.sh)

Access to REST API via HTTP:

    curl -X POST "http://localhost:7000/api/token"

Access to PHP container:

    docker exec -it sum-machine-php sh

Access to PostgreSQL database container:

    docker exec -it sum-machine-db sh

You can use Adminer GUI to easily manage local PostgreSQL database:

> http://localhost:7002

## CLI commands available in PHP container

Apply migrations:

    php artisan migrate

Rollback the last migration:

    php artisan rollback

Launch tests:

    composer test

Launch regular static analysis (PHPStan):

    composer phpstan

Launch regular linter (PHP CS Fixer):

    composer phpcsfixer

Launch regular code check (PHPStan + PHP CS Fixer):

    composer check

Launch deep code check (all scanners):

    composer deep-check

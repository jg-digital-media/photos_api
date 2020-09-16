# photos_api
Photos API in Laravel - **Last Update** - 16/09/202020
Laravel Build: v8.3.0

## Description 

**The Goal:**: Creating a Photos REST API with Laravel, in which photos can be created, updated, deleted, listed and dissplayed in the browser.  Initially with JSON.

## **Progress**: 


## Migrations

```php

Schema::create('authors', function(Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('name');
    $table->string('title');
    $table->string('company');
    $table->string('email')->unique();
    $table->timestamps();   

});

/**
 * Available Column Types
 * https://laravel.com/docs/8.x/migrations#columns*/


```


## Common Commands

+ php artisan key:generate
+ php artisan serve
+ php artisan migrate
+ php artisan migrate:fresh
+ pho artisan db:seed

### Create Models
+ php artisan make:model Model -m - create model with migration
+ php artisan make:model Model - create model 



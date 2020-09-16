# photos_api
Photos API in Laravel - **Last Update** - 16/09/202020
Laravel Build: v8.3.0

## Description 

**The Goal:**: Creating a Photos REST API with Laravel, in which photos can be created, updated, deleted, listed and dissplayed in the browser.  Initially with JSON.

## **Progress**: 

+ Have Set up successful database migrations
+ Created Models for Photos and Owners
+ Have defined database relationships using Eloquent Syntax
+ Have created database seeder files based on the Models


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

### Factories and Seeders

+ Model factories are used to generate large amounts of dummy data to speed up development.
+ php artisan make:seeder PhotosTableSeeder
+ php artisan make:seeder OwnersTableSeeder

### Notes

In a change to v8 of Laravel, Models now include use of hasFactory.  keeping this for now.

```php

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;
}

```

In Laravel 8:  DatabaseSeeder.php now contains a call to generate 10 records - uncommented by default

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $this->call( PhotosTableSeeder::class );
        $this->call( OwnersTableSeeder::class );
    }
}

```
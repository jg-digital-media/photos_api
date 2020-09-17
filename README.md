# photos_api
Photos API in Laravel - **Last Update** - 17/09/202020  13:15 BST
Laravel Build: v8.3.0

## Description 

**The Goal:**: Creating a Photos REST API with Laravel, in which photos can be created, updated, deleted, listed and displayed in the browser.  Initially with JSON.

## **Progress**: 

+ Have Set up successful database migrations.
+ Created Models for Photos and Owners.
+ Have defined database relationships using Eloquent Syntax.
+ Have created database seeder files based on the Models.
+ Have created factory files with Artisan. They've changed in Laravel 8. How to use Faker library?
+ Have successfully seeded the Models with test data.
+ Some doubt about whether Eloquent Relationships have been successfully been set up but basic commands working un /tinker that verifies the test records are there.
+ Created the API Resource Controllers for Owner and Photos.

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

## Resource Controllers


### List records with index method.

```php 

<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
      //content
    public function index()
        {
            //all records
            return response(Owner::all(), 200);
        
        }
}  

```

### Validate new data in store() method.  v1

```php

    $data = $request->validate([
        'name' => 'required',
        'copyright' => 'required',
        'year' => 'required'
    ]);

    $owner = new Owner();

    $owner->name = $data->name;
    $owner->title = $data->title;
    $owner->year = $data->year;

    $owner->save();

    return response($owner, 201);  //201 created

    //shorter syntax
    return response(Owner::create($data, 201)) //201 created
```

### Validate new data in store() method.  v2

```php

    //create a new record
    $data = $request->validate([
        'name' => 'required',
        'copyright' => 'required',
        'year' => 'required'
    ]);

    //shorter syntax
    return response(Owner::create($data, 201)) //201 created

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
+ php artisan make:factory OwnerFactory
+ php artisan make:factory PhotoFactory

### Testing Records with Tinker

+ Photo::all()
+ Owner::all()
+ Photo::first()
+ Owner::first()
+ Photo::count()
+ Owner::count()
+ Photo::first()->owner  ====> ```Checking entity relationship``` **OK**
+ Owner::first()->photos

### Controllers and Resource Controllers

+ php artisan make:controller NamedControlller
+ php artisan make:controller PhotoController -r --api
+ php artisan make:controller OwnerController -r --api


## Notes

### Models

+ In a change to v8 of Laravel, Models now include use of hasFactory.  keeping this for now.

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

+ In Laravel 8:  DatabaseSeeder.php now contains a call to generate 10 records - uncommented by default

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

### Factories

+ Factories have undergone a big change in Laravel 8.  This is what you get when you now create Factories in Artisan

```php
<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
```

### TableSeeders

+ NamedTableSeeder.php - 

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //connect factory to seeder
        //factory( \App\Models\Photo::class, 10)->create();
        \App\Models\Photo::factory()->count(10)->create(); 

    }
}

```

### Controllers

+ PhotoController.php

+ use import for App\Models\Model  - change from Laravel 8.

```php

<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}


```

## Links

### Calling Factories in Laravel 8

https://stackoverflow.com/questions/63816395/laravel-call-to-undefined-function-database-seeders-factory - Stack Overflow - Call to undefined function - seeders in Laravel 8


### index method display all records
public function index() {
    return response(Author::all(), 200);
}

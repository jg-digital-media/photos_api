# photos_api
Photos API in Laravel - **Last Update** - 23/09/202020  13:00 BST
Laravel Build: v8.3.0


## Contents

+ Description
+ Progress
+ Common Commands
+ Migrations 
+ Resource Controllers
+ Resources
+ Testing API Endpoints
+ Notes
+ Links


## Description 

**The Goal:** 

+ Creating a Photos REST API with Laravel, in which photos can be created, updated, deleted, listed and displayed in the browser.  Initially with JSON.

+ Would also like to expand this to display in a dynamic HTML format in the future

## **Progress**: 

+ Have set up successful database migrations.
+ Created Models for Photos and Owners.
+ Have defined database relationships using Eloquent Syntax.
+ Have created database seeder files based on the Models.
+ Have created factory files with Artisan. They've changed in Laravel 8. How to use Faker library?
+ Have successfully seeded the Models with test data.
+ Some doubt about whether Eloquent Relationships have been successfully been set up but basic commands working in Tinker REPL that verifies the test records are there.
+ Have created the API Resource Controllers for Owner and Photos.
+ Currently going through the CRUD methods in the Resource Controllers - Why are we not using a return statement for the PhotosController store() method??
+ Have successfully fixed a breaking change with defining routes so data is retrieved from both index() methods of their Controllers.
+ Have successfully connected a Controller file to its accompanying Resource file to filter display of records.
+ Have successfully created test endpoints which use CRUD operations in Controller files including adding a new Owner record with store().
+ Have Successfully created update() method endpoints and updated a specific record with new data. It correctly returns **201 Created**.
+ Unable to delete owner record. Returns **500 Internal Server Error**.
  + Now completed per this Stack overflow thread. https://stackoverflow.com/questions/64012115/im-returning-a-500-internal-server-when-trying-to-delete-a-record-in-laravel-8 


+ Testing store() method of PHOTO - returns **302 FOUND**.
+ Testing destroy() method of PHOTO - returns **204**.
+ Testing update() method of PHOTO - returns **302 FOUND**.
+ Have Successfully cloned and tested the same CRUD operations from another location. ```composer update``` plus saved database credentials.




## Common Commands

+ php artisan key:generate
+ php artisan serve
+ php artisan migrate
+ php artisan migrate:fresh
+ pho artisan db:seed
+ php artisan route:list

### Create Models

+ Models define table data and define the columns that will be changeable in the app.

  + **```php artisan make:model Model-m```** - create model with migration
  + **```php artisan make:model Model```** - create model 

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

+ Defines and runs CRUD Operation methods based on the Model.
  + php artisan make:controller NamedControlller
  + php artisan make:controller PhotoController -r --api
  + php artisan make:controller OwnerController -r --api

### Resources

+ Filter display of database specific ecords

  + php artisan make:resource PhotoResource
  + php artisan make:resource OwnerResource

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

## Routes

```php

use Illuminate\Support\Facades\Route;

/* <snip> */

Route::get( 'owners', 'OwnerController@index' );
Route::get( 'owners/{owner}', 'OwnerController@show' );
Route::put( 'owners/{owner}', 'OwnerController@update' );
Route::patch( 'owners/{owner}', 'OwnerController@update' );
Route::post( 'owners', 'OwnerController@store' );
Route::delete( 'owners/{owner}', 'OwnerController@destroy' );

Route::get( 'photos', 'PhotoController@index' );

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

### index() method of a Resource Controller File. v1 

```php
    public function index() {
        //list all records
        return response(Photo::all(), 200);
        
    }
```

### index() method of a Resource Controller File. v2

```php

    public function index() {
            //list all records
            return response( OwnerResource::collection( Owner::all(), 200) );
            
    }
```

### Validate new data in store() method of OwnerController. v1

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

### Validate new data in store() method of OwnerController. v2

```php

<?php
    //create a new record
    $data = $request->validate([
        'name' => 'required',
        'copyright' => 'required',
        'year' => 'required'
    ]);

    //shorter syntax
    return response(Owner::create($data, 201)) //201 created
?>

```

### Refactored Validate new data in store() method of OwnerController. v3

```php
<?php

    public function store(Request $request) {
        //create a new record   
        $validate = Validator::make($request->toArray(),[
            'name' => 'required',
            'copyright' => 'required',
            'year' => 'required'
        ]);

        //return response(Owner::create($data, 201)); //201 created
        return response(new OwnerResource(Owner::create($validate->validate())), 201); //201 created
    }

?>
```

### Validate new data in store() method of PhotoController. v1

```php
<?php
    public function store(Request $request) {
        //
        $data = $request->validate([
        "url" => "required",
        "caption" => "required",
        "owner_id" => "required"
        ]);

        $photo = Photo::create($data);
        //why no return keyword?
    }
```

### Validate new data in store() method of Photo Controller. v2

```php
<?php

    public function store(Request $request) {
        //
        $validate = Validator::make($request->toArray(), [
            "url" => "required",
            "caption" => "required",
            "owner_id" => "required"
            ]);

        return response( new PhotoResource(Photo::create($validate->validate() ) ), 201);
        //why no return keyword?
    }


```


### Display a specific record with show() method of OwnerController. v1

```php
<?php
    public function show(Owner $owner) {
        return response($owner, 200);
    }

```

### Display a specific record with show() method of OwnerController. v2

```php
    public function show(Owner $owner) {
        return response( new OwnerResource($owner), 200);
     }

```

### Display a specific record with show() method of OwnerController. v1

```php
    public function show(Owner $owner) {
        return response( new OwnerResource($owner), 200);
     }

```

### Display a specific record with show() method of PhotoController v1

```php
<?php
    public function show(Photo $photo) {
        return response( new OwnerResource($photo), 200);
    }

```


### Update a specific record with update() method of OwnerController. v1

```php
<?php
    public function update(Request $request, Owner $owner) {
        //update a specific record
        $data = $request->validate([
            'name' => 'required',
            'copyright' => 'required',
            'year' => 'required'
        ]);

        $owner->update($data);

        return response($owner->update($data), 200);


    }
```

### Update a specific record with update() method of OwnerController v2

```php
    public function update(Request $request, Owner $owner) {
            //update a specific record
            $validate = Validator::make($request->toArray(),[
                'name' => 'required',
                'copyright' => 'required',
                'year' => 'required'
            ]);


            //use this line to capture the existing data record
            $owner->update( $validate->validate() );

            //return the response
            return response( new AuthorResource($owner), 201);


        }

```


### Update a specific record with update() method of PhotoController. v1

```php
<?php 
public function update(Request $request, Photo $photo) {
        //
        $data = $request->validate([
            "url" => "required",
            "caption" => "required",
            "owner_id" => "required"
        ]);

        //photo update method?
        return response( $photo->update($data), 200 );
    
    }
```

### Update a specific record with update() method of PhotoController. v2

```php

<?php
public function update(Request $request, Photo $photo) {
        //
        $validate = Validator::make($request->toArray(), [
            "url" => "required",
            "caption" => "required",
            "owner_id" => "required"
        ]);

        $photo->update( $validate->validate() );

        return response( new PhotoResource( $photo ), 200);
    
    }
```

### Delete a specific record with destroy() method of OwnerController. v1

```php
   public function destroy(Owner $owner)
    {
        //destroy a specific record
        $author->delete();
        return response(null, 204);
    }
```

### Delete a specific record with destroy() method of OwnerController v2

```php
   public function destroy(Owner $owner)
    {

        foreach($owner->photos as $photo) {
            $photo->delete();
        }

        //destroy a specific record
        $owner->delete();
        return response(null, 204);
    }
```

### The Destroy method - No Validation class.

Remains the same. Should return Status code 204.

## Resources

+ Resources help control which specific pieces of data will be displayed in the API. Some database columns should be hidden.

```php
```

### Connecting Resources to Controllers 

+ Changes to Controller CRUD methods to use resources - returning either a single new resource or a collection

```php
    <?php
    public function index() {
        //list all records
        return response( OwnerResource::collection( Owner::all(), 200) );
            
    }
    ?>
```

```php
    <?php
    public function show(Owner $owner) {
    return response( new OwnerResource($owner), 200);

    }
    ?>

```

```php

<?php
public function store(Request $request)
    {
        //create a new record   
        $data = $request->validate([
            'name' => 'required',
            'copyright' => 'required',
            'year' => 'required'
        ]);

        //return response(Owner::create($data, 201)); //201 created
        return response( new OwnerResource( Owner::create($data)), 201); //201 created

    }
?>
```

```php

```

## Testing API Endpoints

+ Testing endpoints project in development 

```rest_test.http
### All Owners

GET http://localhost:8000/api/owners   
# successfully retrieves owners list

```

### Test POST Request for new Owner

```
POST http://localhost:8000/api/owners/
Content-Type: application/json

{
  "name": "Jonathan Grieve",
  "copyright": "JGDM Photography",
  "year": "2020"
}

```
### Test POST Request for editing an Owner


```
POST http://localhost:8000/api/owners/11?_method=PUT
Content-Type: application/json

{
  "name": "Jonnie Grieve",
  "copyright": "JG Photography",
  "year": "2020"
}

```

### DELETE

```
### DELETE a specific record 
DELETE http://127.0.0.1:8000/api/owners/11

```


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

### DatabaseSeeder.php 

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

### Discrepancy - Update() method in Photo and Owner Controllers

+ Not sure why in one function we're using the update() method by itself and returning it in the response and then in the other method only returning the response.  

```php
 public function update(Request $request, Owner $owner)
    {
        //update a specific record
        $data = $request->validate([
            'name' => 'required',
            'copyright' => 'required',
            'year' => 'required'
        ]);

        //use this line to capture the existing data record
        $owner->update($data);

        //return the response
        return response($owner->update($data), 200);


    }
```

```php

public function update(Request $request, Photo $photo)
    {
        //
        $data = $request->validate([
            "url" => "required",
            "caption" => "required",
            "owner_id" => "required"
        ]);

        //owner->update($data);  - not included in video
        return response( $photo->update($data), 200 );
    
    }

```

### Fixing the destroy() method.

+ I had an erroneously named method name iin my owner model.

https://stackoverflow.com/questions/64012115/im-returning-a-500-internal-server-when-trying-to-delete-a-record-in-laravel-8


### Funny business with foreign keys in Resource files.

+ The Photo Resource file contains a reference to the Owner primary key which is called owner_id.  For reasons beyond me it requites another reference called owner for the requests to the PhotoController to work.  Otherwise a 500 Internal Server error is generated.

```php
<?php

    public function toArray($request){
        return [ 
            "url" => $this->url,
            "caption" => $this->caption,
            //"owner_id" => $this->owner_id, 
            "owner" => new OwnerResource($this->owner),
        ];

    }

```

### Route

+ php artisan route:list

```php

 Route::get( 'owners', 'OwnerController@index' );
 Route::get( 'photos', 'PhotoController@index' );

```

### Resources

+ No Breaking Changes with Resource Files in Laravel 8

+ command: php artisan make:resource AuthorResource

+ Connect Resources - in index method of Controller file

```php

<?php 


use App\Http\Resources\OwnerResource;

//snip

public function index()
    {
        //list all records
        return response( OwnerResource::collection( Owner::all(), 200) );
        
    }


```

## Links

### Calling Factories in Laravel 8

https://stackoverflow.com/questions/63816395/laravel-call-to-undefined-function-database-seeders-factory - Stack Overflow - Call to undefined function - seeders in Laravel 8


### index method display all records

```php

<?php
    public function index() {
        return response(Author::all(), 200);
    }

?>

```

### Routes


+ Defining Routes to controllers has changed in Laravel 8.

+ Per this link

https://laracasts.com/discuss/channels/laravel/target-class-carriercontroller-does-not-exist

+ Make the following changes to your RouteServiceProvider.php file in your Laravel 8 Project.

```php
<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * If specified, this namespace is automatically applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';  //change namespace to point to Controller class

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('web')
                ->namespace($this->namespace)   //add this line
                ->group(base_path('routes/web.php'));

            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)  //add this line
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}

```

### Validator Class Support Facade

+ import with ```use Illuminate\Support\Facades\Validator;```
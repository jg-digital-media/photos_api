<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Http\Resources\OwnerResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //list all records
        return response( OwnerResource::collection( Owner::all(), 200) );
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create a new record   
        $validate = Validator::make($request->toArray(),[
            'name' => 'required',
            'copyright' => 'required',
            'year' => 'required'
        ]);

        //return response(Owner::create($data, 201)); //201 created
        return response(new OwnerResource(Owner::create($validate->validate())), 201); //201 created
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Owner $owner) {
        return response( new OwnerResource($owner), 200);
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Owner $owner)
    {
        //update a specific record
        $validate = Validator::make($request->toArray(),[
            'name' => 'required',
            'copyright' => 'required',
            'year' => 'required'
        ]);


        //use this line to capture the existing data record
        $owner->update( $validate->validate() );

        //return the response
        return response( new OwnerResource($owner), 201);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Owner $owner)
    {
    
        foreach($owner->photos as $photo) {
            $photo->delete();
        }

        //destroy a specific record
        $owner->delete();
        return response(null, 204);
    
    }
}

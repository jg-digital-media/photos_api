<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Http\Resources\PhotoResource;
use Illuminate\Support\Facades\Validator;
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
        //list all records
        return response( PhotoResource::collection( Photo::all(), 200) );
        
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
        $validate = Validator::make($request->toArray(), [
            "url" => "required",
            "caption" => "required",
            "owner_id" => "required"
            ]);

        return response( new PhotoResource(Photo::create($validate->validate())), 201);
        //why no return keyword?
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo) 
    {
        return response( new PhotoResource($photo), 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //update a specific record
        $validate = Validator::make($request->toArray(), [
            "url" => "required",
            "caption" => "required",
            "owner_id" => "required"
        ]);

        //use this line to capture the existing data record
        $photo->update( $validate->validate() );

        //return the response
        return response( new PhotoResource( $photo ), 201);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //delete photo
        $photo->delete();
        return response(null, 204);
    }
}

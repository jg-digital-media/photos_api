<?php

namespace App\Http\Controllers;

use App\Models\Owner;
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
        return response(Owner::all(), 200);
        
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
        $data = $request->validate([
            'name' => 'required',
            'copyright' => 'required',
            'year' => 'required'
        ]);

        return response(Owner::create($data, 201)); //201 created
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Owner $owner)
    {
        return response($owner, 200);
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

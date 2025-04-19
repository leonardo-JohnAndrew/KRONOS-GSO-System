<?php

namespace App\Http\Controllers;

use App\Models\posts;
use App\Http\Requests\StorepostsRequest;
use App\Http\Requests\UpdatepostsRequest;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return everything 
        return posts::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dito nilalagay ung validation 
         $data =   $request->validate([
               'title' =>'required|max:255',
               'body'=>'required'
        ]);

         $posts =  posts::create($data); // lalagay na sa  database 
         return ['posts' => $posts]; // if success

    
    }

    /**
     * Display the specified resource.
     */
    public function show(posts $posts)
    {
        //
             return $posts;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, posts $posts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(posts $posts)
    {
        //
    }
}

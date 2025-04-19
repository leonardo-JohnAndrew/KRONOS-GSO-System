<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
      public function show(){
         
        $venue = Material::get();
        return response()->json([
             $venue
        ]);
      }
}

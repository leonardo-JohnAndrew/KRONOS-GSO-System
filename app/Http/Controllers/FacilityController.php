<?php

namespace App\Http\Controllers;

use App\Models\facilities;
use App\Models\facility_request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityController extends Controller
{
    //
      public function index(){
            $data = DB::table('facilities')
            ->select('facilityID', 'facilityName')
            ->get();
            $code = facility_request::generateNextRequestCoded();
             return  [ 
                  "reqstCODE"=> $code,
                  "facility" => $data
             ]; 
      }
}

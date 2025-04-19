<?php

namespace App\Http\Controllers;

use App\Models\admin_facility_request;
use App\Models\facility_request;
use App\Models\Material;
use Illuminate\Http\Request;

class FacilityAdminController extends Controller
{
    //
    public $facilityRequest = [];
    public function viewAll()
    {
        // conditio with view all only the request by userrole is GSO-Director
        $admin_facilityrequest = facility_request::with(['user', 'materials'])->get();
        foreach ($admin_facilityrequest as $admin_request) {
            if ($admin_request->user->userRole == "GSO Director") {
                $this->facilityRequest[] = $admin_request;
            }
        }

        // get request from adminApproval Facility 
        $facilityRequest_admin = admin_facility_request::with('facility_request');
        if (!empty($facilityRequest_admin)) {
            $this->facilityRequest[] = $facilityRequest_admin;
        }


        return  $this->facilityRequest ? $this->facilityRequest : 'No Facility Request';
    }
}

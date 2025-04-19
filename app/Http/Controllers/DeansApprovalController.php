<?php

namespace App\Http\Controllers;

use App\Models\deans_Approval;
use App\Models\facilities;
use App\Models\facility_request;
use App\Models\job_request;
use App\Models\purchase_request;
use App\Models\requests;
use App\Models\service_request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeansApprovalController extends Controller
{
    //checker 
    public function requestChecker($id,  $requestType)
    {
        // selection of request Type  
        switch ($requestType) {
            case 'FR':
                $typerq = facility_request::where('reqstCODE', $id)->get();
                $type = "Facility";
                break;
            case 'VR':
                $typerq = service_request::where('reqstCODE', $id)->get();
                $type = "Vehicle";
                break;
            case 'JR':
                $typerq = job_request::where('reqstCODE', $id)->get();
                $type = "Job";
                break;
            case 'PR':
                $typerq = purchase_request::where('reqstCODE', $id)->get();
                $type = "Purchase";
                break;
            default:
                $typerq = collect();
        }
        // find in request model 
        $request = requests::all()->where('reqstCODE', $id);
        if ($typerq->isEmpty() && $request->isEmpty()) {
            return false;
        }
        //validation if already approved by the admin 
        foreach ($typerq as $key) {
            if ($key->facultyApproval == 'Done' && $key->remark == 'Pending') {
                return [
                    "type" => $type,
                    "data" => $key
                ];
            } else {
                return false;
            }
        }
    }
    public function facility()
    {
        // condition same dapartment and Organization
    }
    public function service()
    {
        // condition same dapartment and Organization
    }
    public function purchase()
    {
        // condition same dapartment and Organization
    }
    public function job()
    {
        // condition same dapartment and Organization
    }
    public function deans_Approval(Request $request)
    {
        $firstname = Auth::user()->firstname;
        $surname = Auth::user()->lastname;
        //validations 

        $data = $request->validate([
            "reqstCODE" => "required",
            "deanID" => "required|string",
            "deansApproval" => "required|string",
            "notification" => "required|string",
            "reason" => "nullable|string",
            "type" => "string|required",
            "remark" => "required",
        ]);

        $code = $request->reqstCODE;
        $type  = $request->type;

        $valid = $this->requestChecker($code, $type);

        if ($valid == false) {
            return response()->json([
                "message" => "This is an Invalid Request"
            ]);
        }
        if ($firstname ==  ''  && $firstname == ' ') {
            return response()->json([
                "message" => "Unable to approve"
            ]);
        }
        // perform actions
        //not insert just notify the requestor for rejection 
        if ($request->remark == 'Rejected') {
            if (empty($request->reason)) {
                return response()->json([
                    "message" => "Required  to fill up Reason to Reject"
                ]);
            } else
                $notification = "Your " . $valid['type'] . " Request is Rejected by : " . $surname . ", " . $firstname;
            $reason = $request->reason;
            $remark = "Rejected";
            $message = "This Request Form is Rejected";
            //inserting to deans_appved table  if Accepted
        } elseif ($request->remark == "Approved") {

            $notification = "Your " . $valid['type'] . " Request is Approved by : " . $surname . ", " . $firstname;
            $message = "This Request Form is Approve";
        } else {
            return [
                "message" => "Something Wrong"
            ];
        }
    }
}

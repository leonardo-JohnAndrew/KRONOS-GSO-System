<?php

namespace App\Http\Controllers;

use App\Models\service_request;
use App\Http\Requests\Storeservice_requestRequest;
use App\Http\Requests\Updateservice_requestRequest;
use App\Models\requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return [

            "reqstCODE" => service_request::generateNextRequestCoded()
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function submit(Request $request)
    {
        //
        $request->validate([
            'reqstType' => 'required',
            'noOfPassenger' => 'integer|required',
            'destination' => 'required|string',
            'passengerName' => 'required|string',
            'purpose' => 'required',
            'timeDeparture' => 'required|date_format:H:i',
            'timeArrival' => 'required|date_format:H:i',
            'dateNeeded' => 'required|date|date_format:Y-m-d',
            'dateArrival' => 'required|date|date_format:Y-m-d',
            'notification' => 'string|nullable',
            // 'facultyApproval' => 'in:Approved,Rejected,Pending','Null',
            'remark' => 'in:Pending,Ongoing,Completed,Rejected,Null',

        ]);
        $serviceRequest = service_request::create([
            'reqstType' => "VR",
            'reqstCODE' => service_request::generateNextRequestCoded(),
            'noOfPassenger' => $request->noOfPassenger,
            'destination' => $request->destination,
            'dateSubmit' => now(),
            'purpose' => $request->purpose,
            'passengerName' => $request->passengerName,
            'timeDeparture' => $request->timeDeparture,
            'timeArrival' => $request->timeArrival,
            'dateArrival' => $request->dateArrival,
            'dateNeeded' => $request->dateNeeded
        ]);

        $rq = requests::create([
            'userid' => Auth::id(),
            'reqstCODE' => $serviceRequest->reqstCODE,
            'request_type' => 'VR',
            'remark' => 'Pending'
        ]);

        if ($serviceRequest) {
            $code = $serviceRequest->reqstCODE;
            if (!$code) {
                return response()->json([
                    'error' => 'reqstCODE is Missing'
                ], 500);
            }
            return response()->json([
                'message' => 'Submitted',
                'data' => $serviceRequest
            ], 200);
        }
    }

    public function update(Request $request, service_request $srID)
    {
        // validate 
        if (!empty($srID->facultyApproval)) {
            return [
                "message" => "Approval for this Request Form is Done Unable to Reapprove"
            ];
        }
        // check if null or rejected 
        $firstname = Auth::user()->firstname;
        $surname = Auth::user()->lastname;
        if ($firstname ==  ''  && $firstname == ' ') {
            return response()->json([
                "message" => "Unable to approve"
            ]);
        }
        if ($request->remark == 'Rejected') {

            if (empty($request->reason)) {
                return response()->json([
                    "message" => "Required  to fill up Reason to Reject"
                ]);
            } else
                $notification = "Your Facility Request is Rejected by your the Faculty Adviser: " . $surname . ", " . $firstname;
            $reason = $request->reason;
            $remark = "Rejected";

            $srID->reason = $reason;
            $srID->remark = $remark;
            $srID->notification = $notification;
            $message = "This Request Form is Rejected";
        } elseif ($request->remark == "Approved") {
            $message = "This Request Form is Approve";
        } else {
            return [
                "message" => "Something Wrong"
            ];
        }
        // updating the form 
        $srID->facultyID = AUth::id();
        $srID->facultyDateApproval = now();
        $srID->facultyApproval = "Done";

        /// save 
        $srID->save();

        return [
            "message" => $message
        ];
    }
}

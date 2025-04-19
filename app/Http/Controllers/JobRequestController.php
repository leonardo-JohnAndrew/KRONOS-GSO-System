<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storejob_request;
use App\Models\job_request;
use App\Models\jobList;
use App\Models\requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class JobRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $code;
    public function __construct()
    {
        $this->code = job_request::generateNextRequestCoded();
    }

    //show codes 
    public function index()
    {
        return [
            "reqstCODE" => $this->code
        ];
    }
    /**
     * Store a newly created resource in storage.
     */
    public function submit(Storejob_request $request)
    {
        // 'dateNeeded'=>'date|required|date_format:Y-m-d',
        // 'purpose'=>'required|string|max:255',
        // 'jobList'=>'array|Nullable'
        //insert to request
        $insertrequest = requests::create([
            'userid' => Auth::id(),
            'reqstCODE' => $this->code,
            'request_type' => 'JR',
            'remark' => 'Pending'
        ]);
        //insert to job
        if (!$insertrequest) {
            return response()->json([
                'message' => 'insert request failed'
            ]);
        }
        //insert to jobrequest
        $jobrequest = job_request::create([
            'reqstCODE' => $this->code,
            'reqstType' => 'JR',
            'dateSubmit' => now(),
            'dateNeeded' => $request->dateNeeded,
            'purpose' => $request->purpose
        ]);
        if (!$jobrequest) {
            return response()->json([
                "message" => "Failed submition"
            ]);
        }

        //insert joblist 
        if (!empty($request->jobList)) {
            foreach ($request->jobList as $list) {
                jobList::create([
                    'reqstCODE' => $this->code,
                    'particulars' => $list['particulars'],
                    'quantity' => $list['quantity'],
                    'natureofWork' => $list['natureofWork'],
                    'jbrqremarks' => $list['remarks']
                ]);
            }
        }
        //return
        return response()->json([
            "message" => "Successfull Job Request submitted wait for the approval",
            "data" => $jobrequest
        ], 200);
    }
    public function update(Request $request, job_request $jrID)
    {
        // validate 
        if (!empty($jrID->facultyApproval)) {
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
                $notification = "Your Facility Request is Rejected by : " . $surname . ", " . $firstname;
            $reason = $request->reason;
            $remark = "Rejected";

            $jrID->reason = $reason;
            $jrID->remark = $remark;
            $jrID->notification = $notification;
            $message = "This Request Form is Rejected";
        } elseif ($request->remark == "Approved") {
            $notification = "Your Facility Request is Approved by : " . $surname . ", " . $firstname;
            $message = "This Request Form is Approve";
        } else {
            return [
                "message" => "Something Wrong"
            ];
        }
        // updating the form 
        $jrID->facultyID = Auth::id();
        $jrID->facultyDateApproval = now();
        $jrID->facultyApproval = "Done";

        /// save 
        $jrID->save();
        return [
            "message" => $message
        ];
    }
}

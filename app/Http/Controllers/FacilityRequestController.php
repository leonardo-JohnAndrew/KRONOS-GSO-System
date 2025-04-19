<?php

namespace App\Http\Controllers;

use App\Models\deans_Approval;
use App\Models\facilities;
use App\Models\facility_request;
use App\Models\Material;
use App\Models\notification;
use App\Models\requests;
use GuzzleHttp\Psr7\Query;
use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Stmt\Else_;

use function Pest\Laravel\json;
use function PHPUnit\Framework\isEmpty;

class FacilityRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */

    public function showall(Request  $request)
    {
        $request = facility_request::whereHas('user', function ($query) {
            $query->where('dprmtName', Auth::user()->dprmtName);
        })->get();
        return $request;
    }
    public function Submit(Request $request)
    {
        // Validate input
        $request->validate([
            'reqstType' => 'required',
            'participants' => 'integer',
            'activityType' => 'required',
            'facilityID' => 'string',
            'activity' => 'required',
            'purpose' => 'required',
            'activityDateStart' => 'required|date|date_format:Y-m-d H:i:s',
            'activityDateEnd' => 'required|date|date_format:Y-m-d H:i:s|after:activityDateStart',
            'note' => 'string|nullable',
            'notification' => 'string|nullable',
            // 'facultyApproval' => 'in:Approved,Rejected,Pending','Null',
            'remark' => 'in:Pending,Ongoing,Completed,Rejected,Null',
            'materials' => 'array|nullable'
        ]);

        // Check if venue is already reserved
        $existing = facility_request::where('venue', $request->venue)
            ->where(function ($query) use ($request) {
                $query->whereBetween('activityDateStart', [$request->activityDateStart, $request->activityDateEnd])
                    ->orWhereBetween('activityDateEnd', [$request->activityDateStart, $request->activityDateEnd]);
            })->exists();

        if ($existing) {
            return response()->json([
                'message' => 'This date and time is already reserved',
            ], 400);
        }

        $venue = facilities::where('facilityID', $request->facilityID)->select('facilityName')->first();
        $facilityRequest = facility_request::create([
            'facilityID' => $request->facilityID,
            'dateSubmit' => now(),
            'reqstCODE' => facility_request::generateNextRequestCoded(),
            'participants' => $request->participants,
            'purpose' => $request->purpose,
            'venue' => $venue,
            'activityType' => $request->activityType,
            'activity' => $request->activity,
            'activityDateStart' => $request->activityDateStart,
            'activityDateEnd' => $request->activityDateEnd,
            'note' => $request->note,
        ]);

        if ($facilityRequest) {
            $code = $facilityRequest->reqstCODE;
            if (!$code) {
                return response()->json(['error' => 'reqstCODE is missing'], 500);
            }

            $rq = requests::create([
                'userid' => Auth::id(),
                'reqstCODE' => $code,
                'request_type' => 'FR',
                'remark' => 'Pending'
            ]);
            // $notification = notification::create([
            //     ''
            // ])
        }
        if (!$rq) {
            return response()->json([
                "message" => "unable to insert Request"
            ]);
        }

        if (!empty($request->materials)) {
            foreach ($request->materials as $material) {
                $code = $facilityRequest->reqstCODE;
                Material::create([
                    'reqstCODE' => $code,
                    'materialName' => $material['materialName'],
                    'quantity' => $material['quantity'],
                    'available' => false
                ]);
            }
        }

        return response()->json([
            'message' => 'Submitted',
            'data' => $facilityRequest
        ], 200);
    }

    public function update(Request $request, facility_request $frID)
    {

        // validate 
        Gate::authorize('update', $frID);

        // if (!empty($frID->facultyApproval)) {
        //     return [
        //         "message" => "Approval for this Request Form is Done Unable to Reapprove"
        //     ];
        // }
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

            $frID->reason = $reason;
            $frID->remark = $remark;
            $frID->notification = $notification;
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
        $frID->facultyID = AUth::id();
        $frID->facultyApproval = "Done";
        $frID->facultyDateApproval = now();
        $frID->notification = $notification;
        /// save update
        $frID->save();
        return [
            "message" => $message
        ];
    }
}

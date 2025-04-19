<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storepurchase_request;
use App\Models\facility_request;
use App\Models\Material;
use App\Models\purchase_request;
use App\Models\requests;
use App\Models\service_request;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use PDO;

class PurchaseController extends Controller
{
  //
  protected $code;

  public function __construct()
  {
    $this->code = purchase_request::generateNextRequestCoded();
  }
  //generate code

  public function index()
  {
    return [
      "reqstCODE" => $this->code
    ];
  }
  public function store(Storepurchase_request $request)

  {

    $insertrequest = requests::create([
      'userid' => FacadesAuth::id(),
      'reqstCODE' => $this->code,
      'request_type' => 'PR',
      'remark' => 'Pending',
    ]);

    if (!$insertrequest) {
      return response()->json([
        'message' => 'insert request failed'
      ]);
    }

    $purchase_request = purchase_request::create([
      'reqstCODE' => $this->code,
      'reqstType' => 'PR',
      'category' => $request->category,
      'purpose' => $request->purpose,
      'dateNeeded' => $request->dateNeeded
    ]);

    if (!$purchase_request) {
      return response()->json([
        'message' => 'insert purchase failed'
      ]);
    }
    //add to purchase db 
    //add to materials
    if (!empty($request->materials)) {
      foreach ($request->materials as $material) {
        Material::create([
          'reqstCODE' => $this->code,
          'materialName' => $material['materialName'],
          'quantity' => $material['quantity'],
          'available' => false
        ]);
      }
    }

    return response()->json([
      'message' => ' Successfully Purchase Request Inserted',
      'data' => $purchase_request
    ]);
    // return  

  }
  public function update(Request $request, purchase_request $prID)
  {
    // validate 
    if (!empty($prID->facultyApproval)) {
      return [
        "message" => "Approval for this Request Form is Done Unable to Reapprove"
      ];
    }
    // check if null or rejected 
    $firstname = FacadesAuth::user()->firstname;
    $surname = FacadesAuth::user()->lastname;
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

      $prID->reason = $reason;
      $prID->remark = $remark;
      $prID->notification = $notification;
      $message = "This Request Form is Rejected";
    } elseif ($request->remark == "Approved") {
      $message = "This Request Form is Approve";
    } else {
      return [
        "message" => "Something Wrong"
      ];
    }
    // updating the form 
    $prID->facultyID = FacadesAuth::id();
    $prID->facultyDateApproval = now();
    $prID->facultyApproval = "Done";

    /// save 
    $prID->save();
    return [
      "message" => $message
    ];
  }
}

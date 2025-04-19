<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeansApprovalController;
use App\Http\Controllers\FacilityAdminController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FacilityRequestController;
use App\Http\Controllers\JobRequestController;
use App\Http\Controllers\NewsfController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ServiceRequestController;
use App\Models\deans_Approval;
use App\Models\Material;
use App\Models\service_request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Pest\Logging\TeamCity\ServiceMessage;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::post('/register', [AuthController::class, 'register']);
Route::get('/department', [AuthController::class, 'department']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/facility-request/deans-approval', [DeansApprovalController::class, 'deans_Approval']);
// Route::get('/job-request',[JobRequestController::class,'index']); 

Route::middleware('auth:sanctum')->group(
    function () {

        // facility
        Route::get('/venue', [FacilityController::class, 'index']);
        Route::get('/facility-request/view', [FacilityRequestController::class, 'showall']);
        Route::post('/facility-request', [FacilityRequestController::class, 'Submit']);
        Route::patch('/facility-request/{frID}/approval', [FacilityRequestController::class, 'update']);

        //admin facility
        Route::get('/admin-facility/all', [FacilityAdminController::class, 'viewAll']);


        // VEHICLE
        Route::get('/service-request', [ServiceRequestController::class, 'index']);
        Route::post('/service-request/submit', [ServiceRequestController::class, 'submit']);
        Route::patch('/service-request/{srID}/approval', [ServiceRequestController::class, 'update']);

        //  purchase
        Route::get('/purchase-request', [PurchaseController::class, 'index']);
        Route::post('/purchase-request/submit', [PurchaseController::class, 'store']);
        Route::patch('/purchase-request/{prID}/approval', [PurchaseController::class, 'update']);

        // job 
        Route::post('/job-request/submit', [JobRequestController::class, 'submit']);
        Route::get('/job-request', [JobRequestController::class, 'index']);
    }
);

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Testing\Fakes\Fake;

class Material extends Model
{
    //
    use HasFactory; 
    protected $fillable =[
      'reqstCODE' ,'materialName', 'quantity', 'available' 
    ];
     public function facilityrequest (){ 
       return $this->belongsTo(facility_request::class,'reqstCODE','reqstCODE');
     } 
     public function facilities (){
      return $this->belongsTo(facilities::class,'facilityID','facilityID' );
     }
     public function purchaserequest(){
      return $this->belongsTo(purchase_request::class, 'reqstCODE', 'reqstCODE');
     }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobList extends Model
{
    //
     use HasFactory;

     protected $table = 'jobList';
     protected $fillable = [
     'reqstCODE', 'particulars', 'quantity', 'natureofWork','jbrqremarks'
     ]; 
    
     public function job_request(){
       return  $this->belongsTo(job_request::class); 
     }
      
      
}

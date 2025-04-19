<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class facilities extends Model
{
  //

  public function facilityrequest()
  {
    return $this->hasMany(facility_request::class, 'facilityID', 'facilityID');
  }
}

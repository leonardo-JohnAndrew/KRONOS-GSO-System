<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job_request extends Model
{
    //
    use HasFactory;
    protected $table = 'job_request';

    protected $fillable = [
        'reqstCODE',
        'dateSubmit',
        'dateNeeded',
        'purpose'
    ];

    public function jobList()
    {
        return $this->hasMany(jobList::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($job_request) {
            $job_request->reqstCODE = self::generateNextRequestCoded();
        });
    }


    public static function generateNextRequestCoded()
    {
        $latestRequest = self::where('reqstCODE', 'like', "GSO-JR-%")
            ->orderBy('reqstCODE', 'desc')
            ->first();

        if (!$latestRequest) {
            return "GSO-JR-0001";
        }

        // Extract numeric part and increment
        $lastNumber = (int) substr($latestRequest->reqstCODE, 8);
        return "GSO-JR-" . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

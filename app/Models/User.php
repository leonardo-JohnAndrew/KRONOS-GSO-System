<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'userid',
        'email',
        'firstname',
        'middlename',
        'lastname',
        'userRole',
        'dprmtName',
        'organization',
        'officerPosition',
        'archive',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dateRegistered' => 'datetime'
        ];
    }
    public function facilityrequest()
    {
        $facilityRequest =  $this->hasMany(facility_request::class, 'userid', 'userid');
        return $facilityRequest;
    }

    protected $primaryKey = 'userid'; // Set primary key
    public $incrementing = false; // Disable auto-incrementing
    protected $keyType = 'string'; // Set key type to string

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->userid = self::generateNextUserid();
        });
    }

    private static function generateNextUserid()
    {
        $latestUser = self::where('userid', 'like', "GSO-USR-%")
            ->orderBy('userid', 'desc')
            ->first();

        if (!$latestUser) {
            return "GSO-USR-0001";
        }

        // Extract numeric part and increment
        $lastNumber = (int) substr($latestUser->userid, 10);
        return "GSO-USR-" . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
// use Laravel\Nova\Actions\Actionable;

class Church extends Model
{
    use HasFactory;
    use LogsActivity;
    // use Actionable;

    protected static $logAttributes = [
        'chreg',
        'name',
        'slug',
        'name_chi',
        'type',
        'is_nccsmember',
        'address',
        'bldg_name',
        'city',
        'postcode',
        'maddress',
        'mbldg_name',
        'mcity',
        'mpostcode',
        'mission',
        'mission_chi',
        'vision',
        'vision_chi',
        'denomination_id',
        'date_founded',
        'totalMembership',
        'aveWeeklyAttendance',
        'numberOfReverends',
        'numberOfPreachers',
        'numberOfMissionaries',
        'avatar',
        'photo_url',
        'status',
        'is_approved',
        'is_searchable',
        'is_published'
    ];

    protected $fillable = [
        'user_id',
        'chreg',
        'name',
        'slug',
        'name_chi',
        'type',
        'is_nccsmember',
        'address',
        'bldg_name',
        'city',
        'postcode',
        'maddress',
        'mbldg_name',
        'mcity',
        'mpostcode',
        'mission',
        'mission_chi',
        'vision',
        'vision_chi',
        'denomination_id',
        'date_founded',
        'totalMembership',
        'aveWeeklyAttendance',
        'numberOfReverends',
        'numberOfPreachers',
        'numberOfMissionaries',
        'avatar',
        'photo_url',
        'status',
        'is_approved',
        'is_searchable',
        'is_published'
    ];
    
    protected $casts = [
        // 'date_founded' => 'datetime'
    ];

    public static function boot()
    {
        parent::boot();

        // if(auth()->user()->role_id !== 1) {
            
            static::creating(function ($church) {
                $church->user_id = auth()->user()->id;
            });
            
        // }
    }

    /**
     * The denomination of the church.
    **/
    public function denomination()
    {
        return $this->belongsTo(Denomination::class);
    }
    
    /**
     * The roles that belong to the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The services that belong to the church.
     */
    public function service_schedules()
    {
        return $this->hasMany(ServiceSchedule::class, 'church_id');
    }

    /**
     * The contact details that belongs to church
     */
    public function contacts_details() 
    {
        return $this->hasMany(ContactDetails::class, 'church_id');
    }

    /**
     * The pastors and staff of the church
     */
    public function pastors_staffs()
    {
        return $this->hasMany(PastorStaff::class, 'church_id');
    }
}

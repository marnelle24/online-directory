<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Organization extends Model
{
    use HasFactory;
    use Actionable;

    // protected $casts = [
    //     'date_founded' => 'datetime'
    // ];

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
        'category',
        'category_id',
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

    /**
     * The denomination of the church.
    **/
    public function category()
    {
        return $this->belongsTo(OrgCategory::class);
    }

    /**
     * The contact details that belongs to church
     */
    public function contacts_details() 
    {
        return $this->hasMany(OrgContactDetails::class, 'organization_id');
    }
}

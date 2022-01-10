<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PastorStaff extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logAttributes = [
        'title',
        'title_chi',
        'first_name',
        'given_name',
        'first_name_chi',
        'family_name',
        'family_name_chi',
        'position',
        'position_chi',
        'phone',
        'type',
        'status',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'church_id',
        'title',
        'title_chi',
        'first_name',
        'given_name',
        'first_name_chi',
        'family_name',
        'family_name_chi',
        'position',
        'position_chi',
        'phone',
        'type',
        'status',
    ];

    /**
     * Pastors and staffs of the church
     */
    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
// use Laravel\Nova\Actions\Actionable;

class ServiceSchedule extends Model
{
    use HasFactory;
    use LogsActivity;
    // use Actionable;

    protected static $logAttributes = [
        'type',
        'language',
        'scheduleDay',
        'scheduleHour',
        'scheduleMinutes',
        'amOrPm',
        'status',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'church_id',
        'type',
        'language',
        'scheduleDay',
        'scheduleHour',
        'scheduleMinutes',
        'amOrPm',
        'status',
    ];

    /**
     * The roles that belong to the user.
     */
    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id', 'id');
    }

}

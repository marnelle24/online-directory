<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
// use Laravel\Nova\Actions\Actionable;

class ContactDetails extends Model
{
    use HasFactory;
    use LogsActivity;
    // use Actionable;

    protected static $logAttributes = [
        'org_name',
        'value',
        'ctype',
        'extra1',
        'extra2',
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'church_id',
        'org_name',
        'value',
        'ctype',
        'extra1',
        'extra2',
    ];

    /**
     * Contact details of the church
     */
    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
// use Laravel\Nova\Actions\Actionable;

class Denomination extends Model
{
    use HasFactory;
    use LogsActivity;
    // use Actionable;

    protected static $logAttributes = [
        'name', 
        'slug', 
        'status'
    ];

    protected $fillable = [
        'name', 
        'slug', 
        'status'
    ];

    public function churches()
    {
        return $this->hasMany(Church::class);
    }
    
}

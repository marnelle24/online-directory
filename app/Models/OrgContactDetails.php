<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class OrgContactDetails extends Model
{
    use HasFactory;

    use Actionable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'organization_id',
        'org_name',
        'value',
        'ctype',
        'extra1',
        'extra2',
    ];

    /**
     * Contact details of the church
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }


}

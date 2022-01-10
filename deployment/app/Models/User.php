<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
// use Laravel\Nova\Actions\Actionable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use LogsActivity;
    // use Actionable;

    protected static $logAttributes = [
        'firstname',
        'lastname',
        'phoneNum',
        'address',
        'city',
        'postal',
        'email',
        'password',
        'role_id',
        'status',
        'profile_img',
        'remarks',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'phoneNum',
        'address',
        'city',
        'postal',
        'email',
        'password',
        'role_id',
        'status',
        'profile_img',
        'remarks',

    ];

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Methods to categorized admin users. It is hardcoded aside from role_id in the DB
     *
     * @var array
     */
    public function isAdmin()
    {
        $admin_emails = [
            'marnelle24@gmail.com',
            'marnelle.apat@bible.org.sg',
            'karl.godinez@bible.org.sg'
        ];

        return in_array($this->email, $admin_emails);
    }


    /**
     * The role that belong to the user.
     */
    public function role() 
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * The churches that belong to the user.
     */
    public function church()
    {
        return $this->hasMany(Church::class);
        // return $this->belongsToMany(Church::class, 'church_user');
    }

}

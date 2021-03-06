<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable  
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'date_of_birth','city_id' ,'last_donate', 'mobile', 'password','blood_type','pin_code','is_active');

    public function blood_types()
    {
        return $this->morphedByMany('App\Models\BloodType', 'clientable');
    }

    public function notifications()
    {
        return $this->morphedByMany('App\Models\Notification', 'clientable')->withPivot('notification_is_read');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function governorates()
    {
        return $this->morphedByMany('App\Models\Governorate', 'clientable');
    }

    public function posts()
    {
        return $this->morphedByMany('App\Models\Post', 'clientable');
    }

    // public function reports()
    // {
    //     return $this->hasMany('App\Models\Report');
    // }

    public function contacts()
    {
        return $this->hasMany('App\Models\Contacts');
    }

    public function tokens()
    {
        return $this->hasMany('App\Models\Token');
    }

    protected $hidden = [
        'password','api_tokn',
    ];


}
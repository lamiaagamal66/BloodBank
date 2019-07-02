<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable 
{

    protected $table = 'clients'; 
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'date_of_birth', 'last_donate', 'mobile', 'password', 'city_id' );

    public function blood_types()
    {
        return $this->morphedByMany('App\Models\BloodType', 'clientable');
    }

    public function posts()
    {
        return $this->morphedByMany('App\Models\Post', 'clientable');
    }

    public function notifications()
    {
        return $this->morphedByMany('App\Models\Notification', 'clientable')->withPivot('notification_is_read');
    }

    public function cities()
    {
        return $this->belongsTo('App/Models\City');
    }

    public function governorates()
    {
        return $this->morphedByMany('App/Models\Governorate', 'clientable');
    }

    public function orders()
    {
        return $this->hasMany('App/Models\Order');
    }

    public function tokens()
    {
        return $this->belongsTo('App/Models\Token');
    }    

    protected $hidden = [
        'password','api_tokn',
    ];

}
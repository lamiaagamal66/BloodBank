<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('name', 'age', 'quantity', 'blood_type' ,'hospital_name', 'hospital_address', 'latitude', 'longtude', 'city_id', 'mobile');

    public function blood_types()
    {
        return $this->belongsTo('App\Models\BloodType');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function cities()
    {
        return $this->belongsTo('App\Models\City','city_id');
    }

    public function clients()
    {
        return $this->belongsTo('App\Models\Client');
    }

}
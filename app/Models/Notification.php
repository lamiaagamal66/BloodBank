<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model 
{

    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('title', 'content', 'order_id');

    public function clients()
    {
        return $this->morphToMany('App\Models\Client', 'clientable')->withPivot('notification_is_read');
    }

    public function orders()
    {
        return $this->belongsTo('App\Models\Order');
    }

}
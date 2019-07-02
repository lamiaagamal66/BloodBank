<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model 
{

    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable = array('title', 'image', 'body', 'category_id');

    public function clients()
    {
        return $this->morphToMany('App\Models\Client', 'clientable');
    }

    public function categories()
    {
        return $this->belongsTo('App\Models\Category');
    }

}
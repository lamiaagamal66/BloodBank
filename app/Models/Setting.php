<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('about_app', 'mobile', 'email', 'fb_link', 'tw_link', 'insta_link', 'whatsapp_link', 'youtube_link', 'g_plus_link');

}
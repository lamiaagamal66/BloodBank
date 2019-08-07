<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model 
{

    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable = array('client_id','title', 'image', 'body','publish_date', 'category_id');
    protected $appends = array('thumbnail_full_path','is_favourite'); // getIsFavouriteAttribute()

    public function clients()
    {
        return $this->morphToMany('App\Models\Client', 'clientable');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    } 

    public function getThumbnailFullPathAttribute()
    {
        return asset($this->image);
    }

    public function getIsFavouriteAttribute()
    {
        $favourite = $this->whereHas('favourites',function ($query){
            $query->where('clientables.client_id',request()->user()->id);
            $query->where('clientables.post_id',$this->id);
        })->first();
        if ($favourite)
        {
            return true;
        }
        return false;
    }

    // public function favourites()
    // {
    //     return $this->belongsToMany(Client::class);
    // }


}
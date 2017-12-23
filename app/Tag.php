<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = [
        'name', 'status',
    ];

     public function BlogNews()
    {
        return $this->hasOne('App\Post', 'id', 'category_id');
    }

    public function posts()
    {
        return $this->belongsToMany('App\Post', 'post_tag');
    }
}
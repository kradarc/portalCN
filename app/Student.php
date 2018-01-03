<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $table= "students";
    
    protected $fillable = [
        'workshop_id', 'user_id', 'status'
    ];

}
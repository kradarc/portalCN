<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{

    protected $table= "workshops";
    
    protected $fillable = [
        'name', 'place', 'color', 'type', 'subcolor','description', 'user_id', 'status', 'quotas', 'about_quotas', 'cover_page', 'url', 'subtitle', 'age_min', 'age_max', 'category_id'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    //pivot
    public function teachers(){
        return $this->belongsToMany('App\User', 'teachers', 'workshop_id', 'teacher_id')->withPivot('status')->withTimestamps();
    }

    //pivot
    public function students(){
        return $this->belongsToMany('App\User', 'students', 'workshop_id', 'user_id')->withPivot('status')->withTimestamps();
    }

    public function hasStatus()
    {
        return $this->hasOne('App\Status', 'id', 'status');
    }

    public function hasType()
    {
        return $this->hasOne('App\Type', 'id', 'type');
    }

    public function hasCategory()
    {
        return $this->hasOne('App\WorkshopCategories', 'id', 'category_id');
    }

    //total de cupos + sobrecupós
    public function hasTotalQuotes() {
        return $this->quotas + $this->about_quotas;
    }

    //obtener clases de cada workshop

    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }

    public function scopeLessonsBeforeRecord()
    {   
        $ldate = date('Y-m-d');
        return $this->hasMany('App\Lesson')->where('date', '>=', $ldate)->orderBy('date','ASC');
    }

    //total de cupos disponibles 
    //**traigo los registros tabla pivot y le resto al total de quotas
    public function hasTotalQuotesAvaibles() {
        $cupos = $this->belongsToMany('App\User', 'students', 'workshop_id', 'user_id');
        return $this->quotas + $this->about_quotas  - count($cupos->get());
    }



    public function scopeFilterByRequest($query, $column, $value)
    {   
        if (trim($value) != "" && trim($column) != "") {

            switch ($column) {
                case 'role_id':
                    $query->where(\DB::raw("role_id"), "=", $value)->orderBy('id','DESC');
                    break;
                case 'email':
                    $query->where(\DB::raw("email"), "LIKE", "%$value%")->orderBy('id','DESC');
                    break;
                case 'status':
                    $query->where(\DB::raw("status"), "LIKE", "%$value%")->orderBy('id','DESC');
                    break;
            }
        }
    }




    //lista de post activos
    public function scopeGetListActiveWorkshops($query, $value)
    {   
        if ($value == 0) {
            $query->where("status", "=", 1)->orderBy('id','DESC');
        } else {
            $query->where("status", "=", 1)->where('type', '=', $value)->orderBy('id','DESC');
        }
        
    }

    public function scopeGetListActiveWorkshopsAdmin($query)
    {   
        $query->orderBy('id','DESC');
    }

}


    

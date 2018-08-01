<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'image'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    
    /**
     * The users that take the course.
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_course', 'course_id', 'user_id');
    }
}

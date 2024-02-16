<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class ProjectSkill extends Model
{

    use Notifiable;
	use SoftDeletes;

    protected $table = "project_skillsets";

    protected $fillable =
        [
            'project_id',
            'skill_id',
        ];

    protected $hidden =
        [
            '_token',
        ];
	
	public function skill() {
        return $this->hasOne(Skill::class, 'id', 'skill_id');
    }

}
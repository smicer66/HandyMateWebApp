<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class ArtisanSkill extends Model
{
    use Notifiable;
	use SoftDeletes;
	
	protected $table = 'artisan_skills';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'skill_id',
    ];

    public function skill() {
        return $this->hasOne(Skill::class, 'id', 'skill_id');
    }
	
	
	public function artisan() {
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }
}

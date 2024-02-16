<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Skill extends Model
{
    use Notifiable;
	use SoftDeletes;
	
	protected $table = 'skills';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'skill_name', 'inspection_required',
    ];

    
}

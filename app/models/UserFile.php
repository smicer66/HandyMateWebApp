<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class UserFile extends Model
{
    use Notifiable;
	use SoftDeletes;
	
	protected $table = 'user_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name', 'user_id',
    ];

    
}

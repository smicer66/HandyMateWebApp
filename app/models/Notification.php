<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Notification extends Model
{
    use Notifiable;
	use SoftDeletes;
	
	protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text1', 'text2', 'text3',
    ];

    
}

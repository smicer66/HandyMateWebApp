<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class SmsLog extends Model
{
    use Notifiable;
	use SoftDeletes;
	
	protected $table = 'sms_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text1', 'text2', 'text3',
    ];

    
}

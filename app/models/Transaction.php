<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Transaction extends Model
{
    use Notifiable;
	use SoftDeletes;
	protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    
	public function paid_by_user() {
        return $this->hasOne(User::class, 'id', 'transaction_user_id');
    }

    
	public function project() {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
}

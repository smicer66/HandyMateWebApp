<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Wallet extends Model
{

    use Notifiable;
	use SoftDeletes;

    protected $table = "wallets";

    protected $fillable =
        [
            'wallet_owner_user_id',
            'current_balance',
        ];

    protected $hidden =
        [
            '_token',
        ];

	public function created_by_user() {
        return $this->hasOne(\App\User::class, 'id', 'wallet_user_id');
    }
	
	
}
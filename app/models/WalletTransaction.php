<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class WalletTransaction extends Model
{

    use Notifiable;
	use SoftDeletes;

    protected $table = "wallet_transactions";

    protected $fillable =
        [
            'wallet_id',
            'amount',
            'transaction_type',
        ];

    protected $hidden =
        [
            '_token',
        ];

	public function created_by_user() {
        return $this->hasOne(\App\User::class, 'id', 'wallet_owner_user_id');
    }
	
	public function paid_by_user() {
        return $this->hasOne(\App\User::class, 'id', 'paid_by_user_id');
    }
	
	public function wallet() {
        return $this->hasOne(\App\Models\Wallet::class, 'id', 'wallet_id');
    }
	
	
}
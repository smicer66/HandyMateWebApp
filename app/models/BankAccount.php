<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 


class BankAccount extends Model
{

    use SoftDeletes;

    protected $table = "bank_accounts";

    protected $fillable =
        [
            'id',
            'account_name',
            'account_number',
            'bank_id',
            'iban_number',
            'status'
        ];

    protected $hidden =
        [
            '_token',
        ];

    function bank() {
        return $this->hasOne(Banks::class, 'id', 'bank_id');
    }
}

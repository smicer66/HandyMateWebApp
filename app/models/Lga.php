<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Lga extends Model
{

    use Notifiable;
	use SoftDeletes;

    protected $table = "lgas";

    protected $fillable =
        [
            'lga_name',
            'lga_code',
            'state_id',
            'env',
        ];

    protected $hidden =
        [
            '_token',
        ];

	public function state() {
        return $this->hasOne(States::class, 'id', 'state_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class States extends Model
{

    use Notifiable;
	use SoftDeletes;

    protected $table = "states";

    protected $fillable =
        [
            'id',
            'name',
            'code',
            'status',
            'env',
        ];

    protected $hidden =
        [
            '_token',
        ];

    public function countries() {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

}

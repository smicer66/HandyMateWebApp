<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Message extends Model
{

    use Notifiable;
	use SoftDeletes;

    protected $table = "messages";

    protected $fillable =
        [
            'account_name',
            'bank_id',
        ];

    protected $hidden =
        [
            '_token',
        ];

	public function created_by_user() {
        return $this->hasOne(\App\User::class, 'id', 'sender_user_id');
    }
	
	
	public function receipient_user() {
        return $this->hasOne(\App\User::class, 'id', 'receipient_user_id');
    }

	public function district() {
        return $this->hasOne(Lga::class, 'id', 'district_located_id');
    }

	public function state() {
        return $this->hasOne(States::class, 'id', 'province_located_id');
    }
	
	public function country() {
        return $this->hasOne(Country::class, 'id', 'country_located_id');
    }
	
	public function skills() {
        return $this->hasMany(ProjectSkill::class, 'project_id', 'id');
    }
}
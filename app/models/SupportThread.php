<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class SupportThread extends Model
{

    use Notifiable;
	use SoftDeletes;

    protected $table = "support_threads";

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
        return $this->hasOne(\App\User::class, 'id', 'created_by_user_id');
    }
	
	
	public function assigned_bidder() {
        return $this->hasOne(\App\User::class, 'id', 'assigned_bidder_id');
    }

	public function project() {
        return $this->hasOne(\App\Models\Project::class, 'id', 'project_id');
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
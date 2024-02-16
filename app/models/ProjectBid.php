<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class ProjectBid extends Model
{

    use Notifiable;
	use SoftDeletes;

    protected $table = "project_bids";

    protected $fillable =
        [
            'bid_details',
            'project_id',
			'bid_amount'
        ];

    protected $hidden =
        [
            '_token',
        ];

	public function bid_by_user() {
        return $this->hasOne(\App\User::class, 'id', 'bid_by_user_id');
    }

	public function project() {
        return $this->hasOne(\App\Models\Project::class, 'id', 'project_id');
    }
}
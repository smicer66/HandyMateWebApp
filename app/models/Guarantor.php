<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Guarantor extends Model
{
    use Notifiable;
	use SoftDeletes;
	
	protected $table = 'guarantors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'other_name',
    ];

    public function district()
	{
		return $this->hasOne(\App\Models\Lga::class, 'id', 'district_id');
	}
	
	public function province()
	{
		return $this->hasOne(\App\Models\States::class, 'id', 'state_id');
	}
	
	
}

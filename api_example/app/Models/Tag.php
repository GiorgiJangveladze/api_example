<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $table = 'tags';
	protected $fillable = ['title'];
	public $timestamps = false;

	public function article()
	{
	    return $this->belongsToMany('App\Models\Article');
	}
}

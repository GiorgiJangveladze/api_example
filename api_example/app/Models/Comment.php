<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $table = 'comments';
	protected $fillable = ['content'];
	public $timestamps = [ "created_at" ];

	public function articles()
	{
	    return $this->belongsToMany('App\Models\Article');
	}
}

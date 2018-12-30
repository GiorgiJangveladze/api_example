<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $table = 'articles';
	protected $fillable = ['title','content','created_at'];
	public $timestamps = [ "created_at" ];

	public function tags()
	{
	    return $this->belongsToMany('App\Models\Tag');
	}

	public function comments()
	{
	    return $this->belongsToMany('App\Models\Comment');
	}
}

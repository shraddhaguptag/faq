<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#models
use App\Models\Question;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 
        'status',
    ];

    public function questions()
	{
		return $this->hasMany('App\Models\Question','category_id');
	}
}

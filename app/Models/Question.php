<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#models
use App\Models\Category;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 
        'answer',
        'category_id',
        'status',
        'category_status'
    ];

    public function category()
	{
		return $this->belongsTo('App\Models\Category','category_id','id')->where('status', 1);
	}
}

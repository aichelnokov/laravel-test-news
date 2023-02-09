<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubrics extends Model
{
    use HasFactory;

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_rubrics');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Rubrics', 'rubrics_id')->where('rubrics_id', 0)->with('parent');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Rubrics', 'rubrics_id')->with('children');
    }
}

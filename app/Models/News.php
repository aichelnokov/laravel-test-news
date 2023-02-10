<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'announce', 'content'];

    public function rubrics()
    {
        return $this->belongsToMany(Rubrics::class, 'news_rubrics');
    }
}

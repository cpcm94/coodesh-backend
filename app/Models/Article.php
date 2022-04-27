<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'featured', 'title', 'url', 'imageUrl', 'newsSite', 'summary', 'publishedAt'];

    public function launches() {
        return $this->hasMany(Launch::class);
    }

    public function events() {
        return $this->hasMany(Event::class);
    }
}

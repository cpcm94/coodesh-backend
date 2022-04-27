<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Launch extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'provider', 'article_id'];


    public function article() {
        return $this->belongsTo(Article::class);
    }
}

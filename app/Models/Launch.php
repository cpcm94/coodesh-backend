<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Launch extends Model
{
    use HasFactory;

    public function article() {
        return $this->belongsTo(Article::class);
    }
}

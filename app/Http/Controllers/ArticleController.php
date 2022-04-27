<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Route;

class ArticleController extends Controller
{
    public function __invoke($request) {

    $article = Article::where('id', $request)->with(['launches', 'events'])->get();
        
    return response($article);
    }
}

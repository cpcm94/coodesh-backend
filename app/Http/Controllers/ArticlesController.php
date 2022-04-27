<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticlesController extends Controller
{
    public function __invoke() {

        $articles = Article::with(['launches', 'events'])->paginate(10);

        return response($articles);
    }

}

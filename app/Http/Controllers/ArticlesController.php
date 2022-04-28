<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function __invoke(Request $request) {
        $order = $request->order === 'asc' ? 'asc' : 'desc';

        $articles = Article::with(['launches', 'events'])->orderBy('id', $order)->paginate(10);

        return response($articles);
    }

}

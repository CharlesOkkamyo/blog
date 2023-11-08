<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleApiController extends Controller
{
    public function index()
    {
        return Article::all();
    }
    public function store()
    {
        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->save();
        return $article;
    }
    public function show($id)
    {
        return Article::find($id);
    }
    public function update($id)
    {
        $article = Article::find($id);
        $article->title = request()->title;
        $article->save();
        return $article;
    }
    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();
        return $article;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\PostDec;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }

    public function index()
    {
        $data = Article::latest()->paginate(5);
        return view('articles.index', [
            'articles' => $data
        ]);
    }

    public function detail($id)
    {
        $data = Article::find($id);
        return view('articles.detail', ['article' => $data]);
    }

    public function add()
    {
        $data = [
            ["id" => 1, "name" => "News"],
            ["id" => 2, "name" => "Tech"],
        ];
        return view("articles/add", ["categories" => $data]);
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->save();
        return redirect('/articles');
    }


    public function edit($id)
    {
        $data = Article::find($id);
        $categories = [
            ["id" => 1, "name" => "News"],
            ["id" => 2, "name" => "Tech"],
        ];
        return view('articles.edit', ['article'=> $data ], ['categories' => $categories]);
    }
    public function updateitem(Request $request, $id){
        $request = validator(request()->all(), [
            'title'=> 'required|max:255',
            'body' => 'required',
        ]);
        if ($request->fails()) {
            return back()->withErrors($request);
        }
        $article= Article::find($id);
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->update();
        return redirect('/articles')->with('success','Post updated successfully.');
    }

    public function delete($id)
    {
        $article = Article::find($id);
        $article->delete();
        return redirect('/articles')->with('info', 'Article deleted.');
    }
}

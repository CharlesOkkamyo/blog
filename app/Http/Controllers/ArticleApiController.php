<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ArticleApiController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"
        ]);

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        return response()->json([
            "status" => 200,
            "message" => "User created successfully"
        ]);
    }


    public function login(Request $request)
    {

        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        if (!empty($token)) {
            return response()->json([
                "status" => 200,
                "message" => "Logged in successfully!",
                "token" => $token
            ]);
        }

        return response()->json([
            "status" => 400,
            "message" => "Invalid login details.",
        ]);
    }

    public function profile()
    {
        $userData = auth()->User();

        return response()->json([
            "status" => 200,
            "message" => "Profile data retrieved.",
            "user" => $userData,
        ]);
    }

    public function refreshToken()
    {
        $newToken = auth()->refresh();

        return response()->json([
            "status" => 200,
            "message" => "Token generated!",
            "token" => $newToken,
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            "status" => 200,
            "message" => "Logged out successfully."
        ]);
    }

    public function listAll()
    {
        return Article::all();
    }
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|integer',
        ]);

        $article = new Article;
        $article->title = $request->title;
        $article->body = $request->body;
        $article->category_id = $request->category_id;
        $article->save();

        return $article;
    }

    public function find($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'status' => 404,
                'message' => 'Article not found',
            ], 404);
        }

        return Article::find($id);
    }

    public function update(Request $request)
    {

        $request->validate([
            "id" => "required",
            "title",
            "body",
            "category_id",
        ]);

        $article = Article::find($request->id);

        if (!$article) {
            return response()->json([
                'status' => 404,
                'message' => 'Article not found',
            ], 404);
        }

        $article->title = $request->title;
        $article->body = $request->body;
        $article->category_id = $request->category_id;
        $article->save();
        return $article;
    }

    // ArticleApiController.php
    public function delete($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'status' => 404,
                'message' => 'Article not found',
            ], 404);
        }

        $article->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Article deleted successfully',
        ]);
    }

    //public function destroy($id)
    //{
    //    $article = Article::find($id);
    //    $article->delete();
    //    return $article;
    //}
}

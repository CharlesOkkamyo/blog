<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("register",[ArticleApiController::class, "register"]);
Route::post("login", [ArticleApiController::class, "login"]);

Route::group(
    [
        "middleware" => ["auth:api"]
    ], function(){
        Route::get("profile", [ArticleApiController::class, "profile"]);
        Route::get("refresh", [ArticleApiController::class, "refreshToken"]);
        Route::get("logout", [ArticleApiController::class, "logout"]);
        Route::get("listAll", [ArticleApiController::class, "listAll"]);
        Route::get("find/{id}", [ArticleApiController::class, "find"]);
        Route::post("create",[ArticleApiController::class, "create"]);
        Route::post("update", [ArticleApiController::class, "update"]);
        Route::delete("delete/{id}", [ArticleApiController::class, "delete"]);
    }
);

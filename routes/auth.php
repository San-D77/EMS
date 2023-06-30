<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use PharIo\Manifest\AuthorCollection;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$login_url = env("ADMIN_URL", '/');

Route::get("$login_url", function () {
    session()->put("valid-user", "true");
    $url = (URL::temporarySignedRoute('login', now()->addMinutes(2)));
    return redirect()->to($url);
})->name("login_url");

Route::get('/login', [AuthController::class, "login"])->name("login")->middleware(["throttle:5"]);;
Route::post("/login", [AuthController::class, "postLogin"])->name("post-login");

Route::group(["middleware" => "auth"], function () {

    Route::get("/logout", [AuthController::class, "logout"])->name("logout");

    Route::get("/2fa/enable", [AuthController::class, "enableTwoFactor"])->name("2fa-enable");
    // Route::post("/2fa/enable", [AuthController::class, "postEnableTwoFactor"])->name("2fa-enable-post");


    Route::get('/2fa/validate', [AuthController::class, "validate2FA"])->name("validate-2fa");
    Route::post("/2fa/validate", [AuthController::class, "postValidate2FA"])->name("post-validate-2fa")->middleware(["throttle:5", "auth"]);
});

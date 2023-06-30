<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

    /*
        Admin Routes
    */

    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

    Route::group(['prefix' => 'user', "as" => "user-"], function () {
        Route::get("/", [UserController::class, "index"])->name("view");
        Route::get("/create", [UserController::class, "create"])->name("create");
        Route::post("/store", [UserController::class, "store"])->name("store");
        Route::get("/edit/{user}", [UserController::class, "edit"])->name("edit");
        Route::post("/update/{user}", [UserController::class, "update"])->name("update");
        Route::get("/delete/{user}", [UserController::class, "destroy"])->name("delete");
        Route::get("/status-update/{user}", [UserController::class, "updateStatus"])->name("update_status");

        Route::get("/profile/{user}", [UserController::class, "update_profile"])->name("update_profile");
    });

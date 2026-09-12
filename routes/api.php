<?php

use App\Http\Controllers\Api\ShortUrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->prefix("v1")->group(function () {
    Route::get("/short-urls", [ShortUrlController::class, "index"]);
    Route::post("/short-urls", [ShortUrlController::class, "store"]);
});

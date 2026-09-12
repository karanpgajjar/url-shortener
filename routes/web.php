<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return redirect()->route("login");
});

Route::get("/s/{code}", [ShortUrlController::class, "redirect"])->name("short-urls.redirect");

Route::middleware("auth")->group(function () {
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

    Route::get("/profile", [ProfileController::class, "edit"])->name("profile.edit");
    Route::patch("/profile", [ProfileController::class, "update"])->name("profile.update");
    Route::delete("/profile", [ProfileController::class, "destroy"])->name("profile.destroy");

    Route::middleware("role:admin,member")->group(function () {
        Route::post("/short-urls", [ShortUrlController::class, "store"])->name("short-urls.store");
    });

    Route::middleware("role:super_admin")->group(function () {
        Route::post("/companies/invite", [InvitationController::class, "inviteCompanyAdmin"])->name("companies.invite");
    });

    Route::middleware("role:admin")->group(function () {
        Route::post("/team/invite", [InvitationController::class, "inviteTeamMember"])->name("team.invite");
    });
});

require __DIR__ . "/auth.php";

<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $shortUrls = ShortUrl::visibleTo($user)->latest()->paginate(15);

        $companies = $user->isSuperAdmin()
            ? Company::withCount(["users", "shortUrls"])->latest()->paginate(10)
            : null;

        $teamMembers = $user->isAdmin()
            ? User::where("company_id", $user->company_id)->get()
            : null;

        return view("dashboard", [
            "shortUrls" => $shortUrls,
            "companies" => $companies,
            "teamMembers" => $teamMembers,
        ]);
    }
}

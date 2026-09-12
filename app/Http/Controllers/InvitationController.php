<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteCompanyAdminRequest;
use App\Http\Requests\InviteTeamMemberRequest;
use App\Models\Company;
use App\Models\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class InvitationController extends Controller
{

    public function inviteCompanyAdmin(InviteCompanyAdminRequest $request)
    {
        $data = $request->validated();

        $company = Company::create($data["company"]);

        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => Hash::make("password"),
            "company_id" => $company->id,
            "role" => Role::Admin,
        ]);

        Password::sendResetLink(["email" => $user->email]);

        return response()->json([
            "message" => "Invitation sent to {$user->email} for {$company->name}.",
            "reload" => true,
        ]);
    }


    public function inviteTeamMember(InviteTeamMemberRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => Hash::make("password"),
            "company_id" => $request->user()->company_id,
            "role" => Role::from($data["role"]),
        ]);

        Password::sendResetLink(["email" => $user->email]);

        return response()->json([
            "message" => "Invitation sent to {$user->email}.",
            "reload" => true,
        ]);
    }
}

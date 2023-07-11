<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(!Auth::validate($credentials)) {
            return redirect()->route('welcome');
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user, true);

        return redirect()->route('search');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('welcome');
    }

    public function createAdmin()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123'),
            'role' => UserRoleEnum::ADMIN
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ManageUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback(Request $request)
    {
        $user = Socialite::driver('google')->stateless()->user();

        $createUser = User::updateOrCreate(
            ['email' => $user->getEmail()],
            [
                'name' => $user->getName(),
                'google_id' => $user->getId()
            ]
        );

        ManageUser::firstOrCreate(
            ['user_id' => $createUser->id],
            ['status' => 'active']
        );

        Auth::login($createUser);

        $token = $request->user()->createToken('authToken');

        $addToken = User::find($createUser->id);
        $addToken->token = $token->plainTextToken;
        $addToken->save();

        return [
            'status'  => true,
            'token'  => $token->plainTextToken,
        ];
    }

    public function facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebook_callback(Request $request)
    {
        $user = Socialite::driver('facebook')->stateless()->user();

        $createUser = User::updateOrCreate(
            ['email' => $user->getEmail()],
            [
                'name' => $user->getName(),
                'facebook_id' => $user->getId()
            ]
        );

        ManageUser::firstOrCreate(
            ['user_id' => $createUser->id],
            ['status' => 'active']
        );

        Auth::login($createUser);

        $token = $request->user()->createToken('authToken');

        $addToken = User::find($createUser->id);
        $addToken->token = $token->plainTextToken;
        $addToken->save();

        return [
            'status'  => true,
            'token'  => $token->plainTextToken,
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'status'  => true,
            'message' => 'Logout Berhasil!',
        ];
    }
}

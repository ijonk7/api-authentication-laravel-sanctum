<?php

namespace App\Http\Controllers;

use App\Models\ManageUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManageUserController extends Controller
{
    public function index()
    {
        return User::with('manageUser')->simplePaginate(10);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'status' => ['required',Rule::in(['active', 'inactive'])],
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $manageUser = new ManageUser([
            'position' => $request->filled('position') ? $request->position : NULL,
            'status' => $request->status,
            'user_id' => $user->id
        ]);
        $user->manageUser()->save($manageUser);

        $token = $user->createToken('authToken');

        $addToken = User::find($user->id);
        $addToken->token = $token->plainTextToken;
        $addToken->save();

        return [
            'status'  => true,
            'message' => 'User Created Successfully',
        ];
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => [Rule::in(['active', 'inactive'])],
        ]);

        $user->name = $request->name;
        $user->save();

        $user->manageUser->user_id = $user->id;
        $user->manageUser->status = $request->filled('status') ? $request->status : $user->manageUser->status;
        $user->manageUser->position = $request->filled('position') ? $request->position : NULL;
        $user->push();

        return [
            'status'  => true,
            'message' => 'Post Updated Successfully',
        ];
    }

    public function destroy(User $user)
    {
        $user->delete();

        return [
            'status'  => true,
            'message' => 'Post Deleted Successfully',
        ];
    }
}

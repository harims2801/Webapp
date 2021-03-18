<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        return User::all();
    }

    public function show(User $user) {
        return $user;
    }

    public function update(Request $request, User $user){

        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function delete(User $user){
        $user->delete();
        return response()->json(null, 204);
    }

    public function store(Request $request) {

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'user_role' => $request['user_role']
        ]);
        return response()->json($task, 201);
    }

}

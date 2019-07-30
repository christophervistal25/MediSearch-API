<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(Request $request)
    {
        $user = $this->user->where('email', $request->email)->first();
        if (!$user || ($user && !Hash::check($request->password, $user->password)) ) {
            return response()->json(['login' => false, 'message' => 'Please check your username or password'], 422);
        }
        return response()->json(['login' => true, 'message' => 'Authorized']);
    }

    public function register(CreateUserRequest $request)
    {
        
        $created = $this->user->create([
            'fullname'   => $request->fullname,
            'email'      => $request->email,
            'contact_no' => $request->contact_no,
            'address'    => $request->address,
            'password'   => Hash::make($request->password),
        ]);

        return response()->json(['user' => $created], 201);
    }

    public function show($id)
    {
        return $this->user->find($id);
    }

    public function update(Request $request, $id)
    {
        $user = $this->user->find($id);
        $updated = $user->update($request->all());
        return response()->json(['updated' => (bool) $updated]);
    }
}

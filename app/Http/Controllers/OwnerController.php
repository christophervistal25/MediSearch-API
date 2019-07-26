<?php

namespace App\Http\Controllers;
use App\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{
    
    public function index()
    {
        $owners = Owner::orderBy('created_at', 'DESC')
                        ->get();
        return $owners;
    }

    public function login(Request $request)
    {
        $owner = Owner::where('email', $request->email)
                       ->first();

        if ( $owner && !Hash::check($request->password, $owner->password) || !$owner ) {
            return response()->json(['success' => false, 'message' => 'Please check your username or password.'], 422);
        } 
        
        return response()->json(['success' => true, 'message' => 'Authorized.'], 200);

    }

    public function store(Request $request)
    {
        $owner = Owner::create([
                'fullname'   => $request->fullname,
                'email'      => $request->email,
                'contact_no' => $request->contact_no,
                'address'    => $request->address,
                'password'   => Hash::make($request->password),
            ]);

        return response()->json(['created' => (bool) $owner], 201);
    }

}

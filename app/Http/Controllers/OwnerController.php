<?php

namespace App\Http\Controllers;
use App\Owner;
use App\Pharmacist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{
    protected $owner;

    public function __construct(Owner $owner)
    {
        $this->owner = $owner;
    }

    public function index()
    {
        $owners = $this->owner::orderBy('created_at', 'DESC')
                        ->get();
        return $owners;
    }

    /**
     * The checking if the owner is exists is in App\Http\Middleware\IsOwner
     */
    public function login(Request $request)
    {
        $owner = $this->owner->findByEmail($request->email, ['password']);

        if ( !Hash::check($request->password, $owner->password) ) {
            return response()->json(['success' => false, 'message' => 'Please check your username or password.'], 422);
        } 
        
        return response()->json(['success' => true, 'message' => 'Authorized.'], 200);
    }

    public function store(Request $request)
    {
        $created = $this->owner->create([
            'fullname'   => $request->fullname,
            'email'      => $request->email,
            'contact_no' => $request->contact_no,
            'address'    => $request->address,
            'password'   => Hash::make($request->password),
        ]);

        return response()->json(['created' => (bool) $created], 201);
    }

}

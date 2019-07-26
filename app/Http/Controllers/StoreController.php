<?php

namespace App\Http\Controllers;
use App\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function store(Request $request)
    {
        $store = Store::create($request->all());
        return response()->json(['created' => (bool) $store], 201);
    }

    public function update(Request $request, $id)
    {
        $updated = Store::find($id)
                        ->update($request->all());
                        
        return response()->json(['updated' => (bool) $updated]);
    }
}

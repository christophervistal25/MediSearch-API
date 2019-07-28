<?php

namespace App\Http\Controllers;
use App\Store;
use Illuminate\Http\Request;
use App\Medicine;


class StoreMedicineController extends Controller
{

    public function medicines($id)
    {
        $store = Store::with('medicines')->find($id);
        return response()->json(['data' => $store->medicines]);
    }

    /**
     * @param  [type]  $id      [Id of the store]
     */
    public function entry(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $medicine = Medicine::create($request->all());
        $store->medicines()->attach($medicine);
        return response()->json(['created' => $store->exists()], 201);
    }
}

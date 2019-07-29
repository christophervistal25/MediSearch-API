<?php

namespace App\Http\Controllers;
use App\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function update(Request $request, $id)
    {
        $medicine = Medicine::with('ingredients')->find($id);
        if ( $request->has('ingredients') ) {
            // Delete the old ingredient first.
            $medicine->ingredients()->delete();
            // Then add the new one, trick update.
            $medicine->addIngredients($request->ingredients);
        }
        $updated = $medicine->update($request->except('ingredients'));
        return response()->json(['updated' => (bool) $updated]);
    }
}

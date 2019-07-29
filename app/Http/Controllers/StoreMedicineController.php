<?php

namespace App\Http\Controllers;
use App\Ingredient;
use App\Medicine;
use App\Store;
use Illuminate\Http\Request;


class StoreMedicineController extends Controller
{
    protected $medicine;

    public function __construct(Medicine $medicine)
    {
        $this->medicine = $medicine;
    }

    public function medicines($id)
    {
        $store = Store::with(['medicines' => function ($query){
           return $query->with('ingredients');
        }])->find($id);

        return response()->json(['data' => $store->medicines]);
    }

    /**
     * Add an medicine to a store.
     * @param  [type]  $id      [Id of the store]
     */
    public function entry(Request $request, $id)
    {
        $store       = Store::findOrFail($id);
        $medicine    = $this->medicine->create($request->except('ingredient_name'));
        $medicine->addIngredients($request->ingredients);
        $store->medicines()->attach($medicine);
        return response()->json(['created' => $store->exists()], 201);
    }

}

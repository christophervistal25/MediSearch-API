<?php

namespace App\Http\Controllers;
use App\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{  
    protected $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function index()
    {
        $columns = ['id' ,'name', 'located_at'];
        return $this->store->all($columns);
    }

    public function store(Request $request)
    {
        $created = $this->store->create($request->all());
        return response()->json(['created' => (bool) $created], 201);
    }

    public function update(Request $request, $id)
    {
        $updated = $this->store->find($id)
                        ->update($request->all());
                        
        return response()->json(['updated' => (bool) $updated]);
    }
}

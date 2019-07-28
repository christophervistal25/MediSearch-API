<?php

namespace App\Http\Controllers;
use App\Owner;
use App\Store;
use Illuminate\Http\Request;

class OwnerStoreController extends Controller
{
    private $models = [];
    public function __construct(Owner $owner, Store $store)
    {
        $this->models['owner'] = $owner;
        $this->models['store'] = $store;
    }

    /**
     * @param  [type] $id [Owner id]
     */
    public function stores($id)
    {
        $owner = $this->models['owner']
                        ->with('stores')
                        ->find($id);

        return response()->json(['stores' => $owner->stores]);
    }

    /**
     * @param [int]  $id      [Id of the owner]
     */
    public function addStore(Request $request, $id)
    {
        $owner   = $this->models['owner']->find($id);
        $store   = $this->models['store']->create($request->all());
        $owner->stores()->attach($store->id);
        return response()->json(['created' => (bool) $store->exists() ], 201);
    }

    /**
     * @param  [type]  $id      [description]
     * @param  [type]  $storeId [description]
     */
    public function updateStore(Request $request, $id, $storeId)
    {
        
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BuyProduct;
use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function index(){
        return view('pages.dashboard.store-product');
    }

    public function storeList() {
        $stores = Store::with('category')->get();

        $data = [];

        foreach ($stores as $store) {
            $buyProductQty = BuyProduct::where('category_id', $store->category_id)->sum('qty');
            $buyProductUnit = BuyProduct::where('category_id', $store->category_id)->value('unit');
            $data[] = [
                'store' => $store,
                'totalQty' => $buyProductQty,
                'unit' => $buyProductUnit
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function storeCreate(Request $request) {
        // Validate the incoming request data
        $request->validate([
            'category_id' => 'required|integer',
            'uses_qty' => 'required|numeric|min:0'
        ]);

        // Check if a Store entry with the same category_id already exists
        $existingStore = Store::where('category_id', $request->input('category_id'))->first();

        if ($existingStore) {
            return response()->json([
                'message' => 'A store with this Item Name already exists.'
            ], 409); // 409 Conflict status code
        }

        // Create and return the new store entry
        return Store::create([
            'category_id' => $request->input('category_id'),
            'uses_qty' => $request->input('uses_qty')
        ]);
    }


    public function storeItemById(Request $request){
        $store = Store::with('category')->find($request->input('id'));
        return response()->json(['data' => $store]);
    }

    public function storeItemUpdate(Request $request) {
        $request->validate([
            'id' => 'required|exists:stores,id',  // Ensures 'id' exists in 'stores' table
            'uses_qty' => 'required|numeric|min:0',
            'uses_qty_new' => 'required|numeric|min:0'
        ]);
    
        $id = $request->input('id');
        $currentQty = $request->input('uses_qty');
        $additionalQty = $request->input('uses_qty_new');
        $newUsesQty = $currentQty + $additionalQty;
    
        $updateCount = Store::where('id', $id)->update([
            "uses_qty" => $newUsesQty
        ]);
    
        if ($updateCount) {
            $updatedStore = Store::find($id);  // Retrieve updated record
            return response()->json(['data' => $updatedStore]);
        } else {
            return response()->json(['error' => 'Update failed'], 500);
        }
    }
    
}

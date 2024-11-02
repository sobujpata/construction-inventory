<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function CollectionPage(){
        return view('pages.dashboard.collection');
    }

    public function CollectionList(){
        $collections = Collection::with('customer')->get();

        return response()->json($collections);

    }

    public function CollectionCreate(Request $request){
        $request->validate([
            'customer_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'due' => 'nullable|numeric|min:0'
        ]);
        $user_id = $request->header('id');

        // Check if a Collection entry with the same category_id already exists
        $existingCustomer = Collection::where('customer_id', $request->input('customer_id'))->first();
        if ($existingCustomer) {
            return response()->json([
                'message' => 'A Collection with this Customer Name already exists.'
            ], 409); // 409 Conflict status code
        }

        // Create and return the new collection entry
        return Collection::create([
            'user_id' => $user_id,
            'customer_id' => $request->input('customer_id'),
            'amount' => $request->input('amount'),
            'due' => $request->input('due')
        ]);

    }

    public function CollectionById(Request $request){
        $collection = Collection::with('customer')->find($request->input('id'));
        return response()->json(['data' => $collection]);

    }

    public function CollectionUpdate(Request $request){
        $request->validate([
            'id' => 'required|exists:stores,id',  // Ensures 'id' exists in 'stores' table
            'dueAmount' => 'required|numeric|min:0',
            'paymentDue' => 'required|numeric|min:0',
            'mainAmount' => 'required|numeric|min:0'
        ]);
    
        $id = $request->input('id');
        $dueAmount = $request->input('dueAmount');
        $paymentDue = $request->input('paymentDue');
        $mainAmount = $request->input('mainAmount');
        $due = $dueAmount - $paymentDue;
        $amount = $mainAmount + $paymentDue;
    
        $updateCount = Collection::where('id', $id)->update([
            "due" => $due,
            "amount" => $amount
        ]);
    
        if ($updateCount) {
            $updateCollection = Collection::find($id);  // Retrieve updated record
            return response()->json(['data' => $updateCollection]);
        } else {
            return response()->json(['error' => 'Update failed'], 500);
        }
    }
}

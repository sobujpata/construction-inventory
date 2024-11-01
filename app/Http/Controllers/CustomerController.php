<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;
class CustomerController extends Controller
{

    function CustomerPage():View{
        return view('pages.dashboard.customer-page');
    }

    function CustomerCreate(Request $request){

        $user_id = $request->header('id');

        // Validation for product creation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'division' => 'required|integer',
            'district' => 'required|integer',
            'upazila' => 'required|integer',
            'union' => 'required|integer',
            'postalCode' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'presenstAddress' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensures an image file is uploaded
        ]);

        try {
            // Prepare File Name & Path
            $img = $request->file('img');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "profile/{$img_name}";

            // Upload File to the 'profile' folder in public
            $img->move(public_path('profile'), $img_name);

            // Save the customer to the database
            $customer = Customer::create([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
                'division_id'=>$request->input('division'),
                'district_id'=>$request->input('district'),
                'upazila_id'=>$request->input('upazila'),
                'union_id'=>$request->input('union'),
                'postal_code'=>$request->input('postalCode'),
                'village'=>$request->input('village'),
                'present_address'=>$request->input('presenstAddress'),
                'image' => $img_url,
            ]);

            // Return a success response
            return response()->json(['message' => 'customer created successfully', 'customer' => $customer], 201);

        } catch (\Exception $e) {
            // Return error response in case of failure
            return response()->json(['message' => 'customer creation failed', 'error' => $e->getMessage()], 500);
        }
    }


    function CustomerList(Request $request){
        $user_id=$request->header('id');
        return Customer::with('division')->with('district')->with( 'upazila')->with( 'union')->get();
    }


    function CustomerDelete(Request $request){
        $customer_id=$request->input('id');
        $user_id=$request->header('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return Customer::where('id',$customer_id)->delete();
    }


    function CustomerByID(Request $request){
        $customer_id=$request->input('id');
        $user_id=$request->header('id');
        return Customer::where('id',$customer_id)->with('division')->with('district')->with('upazila')->with('union')->first();
    }


     function CustomerUpdate(Request $request){

        // Validate input data
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'mobile' => 'required|numeric',
            'division' => 'required|integer',
            'district' => 'required|numeric',
            'upazila' => 'required|integer',
            'union' => 'required|integer',
            'postalCode' => 'required|integer',
            'village' => 'required|string|max:255',
            'presenstAddress' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure image validation
        ]);

        $user_id = $request->header('id');
        $customer_id = $request->input('id');

        if ($request->hasFile('img')) {
            // Upload new file securely
            $img = $request->file('img');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url="profile/{$img_name}";


        // Upload File
        $img->move(public_path('profile'),$img_name); // Store in public disk

            // Delete old file if it exists
            $filePath = $request->input('file_path');
            if (File::exists(public_path($filePath))) {
                File::delete(public_path($filePath));
            }

            // Update product with new image
            $updated = Customer::where('id', $customer_id)->update([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
                'division_id'=>$request->input('division'),
                'district_id'=>$request->input('district'),
                'upazila_id'=>$request->input('upazila'),
                'union_id'=>$request->input('union'),
                'postal_code'=>$request->input('postalCode'),
                'village'=>$request->input('village'),
                'present_address'=>$request->input('presenstAddress'),
                'image' => $img_url,
            ]);

            if ($updated) {
                return response()->json(['message' => 'Product updated with new image'], 200);
            } else {
                return response()->json(['message' => 'Failed to update product'], 500);
            }
        }

        // Update product without image
        $updated = Customer::where('id', $customer_id)->update([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
                'division_id'=>$request->input('division'),
                'district_id'=>$request->input('district'),
                'upazila_id'=>$request->input('upazila'),
                'union_id'=>$request->input('union'),
                'postal_code'=>$request->input('postalCode'),
                'village'=>$request->input('village'),
                'present_address'=>$request->input('presenstAddress'),
        ]);

        if ($updated) {
            return response()->json([
                'status'=>'success',
                'message' => 'Product updated successfully'
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to update product'], 500);
        }

    }



}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopMaster;
use App\Models\Dropdown;

class ShopController extends Controller
{
    public function index(){
    $item = ShopMaster::get();
    $dropdownShop = Dropdown::where('category','Shop')->get();
       return view('shop.index',compact('item','dropdownShop'));
    }

    public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'shop' => 'required|string|max:255',
        'model_name' => 'required|string|max:255',
    ]);

    // Create a new instance of ShopMaster model and fill it with request data
    $shopMaster = new ShopMaster();
    $shopMaster->shop = $request->shop;
    $shopMaster->model = $request->model_name;

    // Save the data to the database
    $shopMaster->save();

    // Redirect back with success message
    return redirect()->back()->with('status', 'Success Add Shop Master');
}

public function update(Request $request, $id)
{
    // Find the shop master record by id
    $shopMaster = ShopMaster::findOrFail($id);

    // Validate the incoming request data
    $request->validate([
        'shop' => 'required|string|max:255',
        'model_name' => 'required|string|max:255',
    ]);

    // Assign updated values to the model attributes
    $shopMaster->shop = $request->shop;
    $shopMaster->model = $request->model_name;

    // Check if any attributes have been changed
    if ($shopMaster->isDirty()) {
        // Save the changes to the database
        $shopMaster->save();

        // Redirect back with success message
        return redirect()->back()->with('status', 'Shop Master updated successfully');
    } else {
        // Log the attributes for debugging purposes
        logger()->info('No changes detected. Request data:', $request->all());

        // Redirect back with info message
        return redirect()->back()->with('failed', 'No changes detected');
    }
}

    public function delete(Request $request,$id){
        $deleterule=ShopMaster::where('id',$id)
        ->delete();
        if ($deleterule) {
            return redirect()->back()->with('status','Success Delete Dropdown');
        }else{
            return redirect()->back()->with('status','Failed Delete Dropdown');
        }
    }

}

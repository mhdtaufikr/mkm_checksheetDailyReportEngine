<?php

namespace App\Http\Controllers;
use App\Models\ChecksheetHeader;
use App\Models\ChecksheetDetail;
use App\Models\Dropdown;
use App\Models\ShopMaster;

use Illuminate\Http\Request;

class ChecksheetController extends Controller
{
    public function index(){
       $item = ChecksheetHeader::get();
       $dropdownShift =Dropdown::where('category','Shift')->get();
       return view('checksheet.index',compact('item','dropdownShift'));
    }

        public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'dept' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'date' => 'required|date',
            'shift' => 'required|string|max:255',
            'revision' => 'required|integer',
            'no_document' => 'required|string|max:255',
        ]);

        // Create a new instance of ChecksheetHeader model and fill it with request data
        $checksheetHeader = new ChecksheetHeader();
        $checksheetHeader->dept = $request->dept;
        $checksheetHeader->section = $request->section;
        $checksheetHeader->date = $request->date;
        $checksheetHeader->shift = $request->shift;
        $checksheetHeader->revision = $request->revision;
        $checksheetHeader->no_document = $request->no_document;

        // Save the data to the database
        $checksheetHeader->save();
        $id = encrypt($checksheetHeader->id);

        // Redirect to the 'form' route with the encrypted ID as a parameter
        return redirect()->route('form', ['id' => $id]);
    }

    public function showForm($id){
        $id = decrypt($id);
        $item = ChecksheetHeader::where('id',$id)->first();
        $shopMaster = ShopMaster::get();
        $groupedShopMaster = $shopMaster->groupBy('shop');

        return view('checksheet.form',compact('item','shopMaster','groupedShopMaster','id'));
    }

    public function storeDetail(Request $request){
        dd($request->all());
    }

}

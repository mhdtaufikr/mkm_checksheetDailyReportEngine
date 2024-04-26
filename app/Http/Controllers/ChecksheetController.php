<?php

namespace App\Http\Controllers;
use App\Models\ChecksheetHeader;
use App\Models\ChecksheetDetail;
use App\Models\Dropdown;
use App\Models\ShopMaster;
use App\Models\ChecksheetFooter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $checksheetHeader->status = 0;
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

    public function storeDetail(Request $request)
    {
        try {
            DB::beginTransaction();

            // Store data into checksheets_details table
            $dataDetail = [
                'id' => $request->id,
                'shop' => $request->shop,
                'man_power_planning' => $request->man_power_planning,
                'man_power_actual' => $request->man_power_actual,
                'timefrom' => $request->timefrom,
                'timeto' => $request->timeto,
                'pic' => $request->pic,
                'problem' => $request->problem,
                'cause' => $request->cause,
                'action' => $request->action,
            ];

            foreach ($dataDetail['shop'] as $index => $shop) {
                $detail = new ChecksheetDetail();
                $detail->id_checksheet = $dataDetail['id'];
                $detail->shop = $shop;
                $detail->mp_plan = $dataDetail['man_power_planning'][$index];
                $detail->mp_actual = $dataDetail['man_power_actual'][$index];
                $detail->time_from = $dataDetail['timefrom'][$index];
                $detail->time_to = $dataDetail['timeto'][$index];
                $detail->pic = $dataDetail['pic'][$index];
                $detail->problem = $dataDetail['problem'][$index];
                $detail->cause = $dataDetail['cause'][$index];
                $detail->action = $dataDetail['action'][$index];
                $detail->save();
            }

            // Store data into checksheet_footers table
            $dataFooter = [
                "model" => $request->model,
                "shopAll" => $request->shopAll,
                "production_planning" => $request->production_planning,
                "production_actual" => $request->production_actual,
                "production_different" => $request->production_different,
            ];

            foreach ($dataFooter['shopAll'] as $index => $shop) {
                $id_checksheetdtl = ChecksheetDetail::where('shop', $shop)
                    ->where('id_checksheet', $request->id)
                    ->first()
                    ->id;

                $footer = new ChecksheetFooter();
                $footer->id_checksheetdtl = $id_checksheetdtl;
                $footer->model = $dataFooter['model'][$index];
                $footer->prod_plan = $dataFooter['production_planning'][$index];
                $footer->prod_actual = $dataFooter['production_actual'][$index];
                $footer->prod_diff = $dataFooter['production_different'][$index];
                $footer->save();
            }

            // Update checksheets_headers status to 1
            $header = ChecksheetHeader::find($request->id);
            $header->status = 1;
            $header->save();

            DB::commit();

            return redirect()->route('checksheet.index')->with('status', 'success');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('checksheet.index')->with('status', 'failed')->with('error', $e->getMessage());
        }
    }

    public function detail($id){
        $id = decrypt($id);
        $item = ChecksheetHeader::where('id',$id)->first();
       // Fetch the details
            $details = ChecksheetDetail::where('id_checksheet', $id)->get();

            // Initialize an empty array to store footer data
        $footers = [];

        // Loop through each detail
        foreach ($details as $detail) {
            // Fetch the footer corresponding to the current detail
            $footer = ChecksheetFooter::where('id_checksheetdtl', $detail->id)->get();

            // If a corresponding footer is found, merge it into the footers array
            if ($footer) {
                $footers = array_merge($footers, $footer->toArray());
            }
        }


                // Pass the fetched data to the view
                return view('checksheet.detail',compact('details','footers','item','id'));
    }

    public function delete($id)
    {

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the checksheet header
            $checksheetHeader = ChecksheetHeader::findOrFail($id);

            // Find and delete associated details
            $details = ChecksheetDetail::where('id_checksheet', $id)->get();
            foreach ($details as $detail) {
                // Delete associated footers first
                ChecksheetFooter::where('id_checksheetdtl', $detail->id)->delete();
                // Then delete the detail
                $detail->delete();
            }

            // Now delete the header
            $checksheetHeader->delete();

            // Commit the transaction
            DB::commit();

            // Redirect or return success response
            return redirect()->back()->with('success', 'Checksheet deleted successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Handle the error, log it, or return an error response
            return redirect()->back()->with('error', 'Failed to delete checksheet.');
        }
    }

}

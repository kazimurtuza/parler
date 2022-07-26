<?php

namespace App\Modules\VatTaxSetting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\VatTaxSetting\Models\VatTaxSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Array_;

class VatTaxSettingController extends Controller
{

    public function index()
    {
        $common_data = new Array_();
        $common_data->title = 'Vat Setting';
        $common_data->page_title = 'Vat Setting';

        $vats = VatTaxSetting::where('deleted', 0)->get();
        return view("VatTaxSetting::index")
            ->with(compact(
                'common_data',
                'vats'
            ));
    }

    public function store(Request $request)
    {

        $validator = $request->validate([
            'title' => 'required',
            'vat_percent' => 'required',
            'maximum_amount' => 'required',
            'is_default' => 'nullable',
        ]);

            if($request->is_default==1){
                VatTaxSetting::where('deleted',0)->update(['is_default'=>0]);

            }
            $data = $validator;
            $data['status'] = 1;
            $data['created_at'] = Carbon::now();
            $data['created_by'] = Auth::id();
            $data['deleted'] = 0;

           VatTaxSetting::create($data);


        return redirect()->back()->with(['success' => 'Tax Added Successfully']);
    }

    public function edit($id)
    {
        $vat= VatTaxSetting::where('id', $id)
            ->first();
        if (empty($vat)) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid Vat'
            ]);
        }

        $view = view("VatTaxSetting::_edit_vat_tax_data")->with(compact('vat'))->render();
        return response()->json([
            'status' => 200,
            'view' => $view
        ]);
    }

    public function update(Request $request, $id)
    {

            $validator = $request->validate([
                'title' => 'required',
                'vat_percent' => 'required',
                'maximum_amount' => 'required',
                'is_default' => 'nullable',
            ]);

            $vatTax = VatTaxSetting::where('id', $id)
                      ->first();
            if (empty($vatTax)) {
                return redirect()->back()->with(['failed' => 'Invalid Vat']);
            }
            $data = $validator;
            $vatTax->update($data);


        return redirect()->back()->with(['success' => 'Vat Update Successfully']);
    }

    public function updateStatus($id, $status)
    {
        try {
            $vatTax = VatTaxSetting::where('id', $id)
                ->first();
            if (empty($vatTax)) {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Invalid Vat '
                ]);
            }

            $vatTax->status = $status;
            $vatTax->save();
            return response()->json([
                'status' => 200,
                'updated_status' => $status
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 500,
                'msg' => $exception->getMessage()
            ]);
        }
    }
}

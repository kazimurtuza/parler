<?php

namespace App\Modules\Service\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Imports\ServiceImport;
use App\Modules\BranchService\Models\BranchService;
use App\Modules\Service\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\Array_;

class ServiceController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $common_data = new Array_();
        $common_data->title = 'Service';
        $common_data->page_title = 'Service';
        $services=Service::where('deleted', 0)->get();


        return view("Service::index")
            ->with(compact(
                'common_data',
                'services'
            ));
    }

    public function store(Request $request)
    {


        $validator = $request->validate([

            'name' => 'required',
            'price' => 'required',
            'discount_type' => 'required',
            'discount_value' => 'required',
            'description' => 'nullable',
            'image' => 'nullable',
        ]);


        $service=new Service();
        $service->name=$request->name;
        $service->price=$request->price;
        $service->discount_type=$request->discount_type;
        $service->discount_value=$request->discount_value;
        $service->description=$request->description;
        if ($request->hasFile('image')) {
            $name = "icon_".time().rand(1000,9999). "." . $request->file('image')->extension();
            $icon_url = CommonHelper::uploadFile($request->file('image'), $name, 'service');
            $service->image = $icon_url;
        }

        $service->save();


        return redirect()->back()->with(['success' => 'Service Added Success']);
    }

    public function edit($id)
    {
        $services=Service::find($id);

        if (empty($services)) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid Service'
            ]);
        }

        $view = view("Service::_edit_service_data")->with(compact('services'))->render();
        return response()->json([
            'status' => 200,
            'view' => $view
        ]);
    }
//
    public function update(Request $request, $id)
    {
        try {
            $validator = $request->validate([
                'name' => 'required',
                'price' => 'required',
                'discount_type' => 'required',
                'discount_value' => 'required',
                'description' => 'nullable',
                'image' => 'nullable',
            ]);
            $service=Service::find($id);

            if ($request->hasFile('image')) {
                $name = "icon_".time().rand(1000,9999). "." . $request->file('image')->extension();
                $icon_url = CommonHelper::uploadFile($request->file('image'), $name, 'service');
                $validator['image'] = $icon_url;
            }else{
                $validator['image'] = $service->image;
            }

            $service->update($validator);

        } catch (\Exception $exception) {
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        return redirect()->back()->with(['success' => 'Service Update Successs']);
    }
//
    public function updateStatus($id, $status)
    {
        try {
            $service = Service::where('id', $id)
                ->first();
            if (empty($service)) {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Invalid Service'
                ]);
            }

            $service->status = $status;
            $service->save();
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

    public function delete($id)
    {
        $service = Service::find($id);
        $service->status = 0;
        $service->deleted_at=Carbon::now();
        $service->deleted_by = Auth::id();
        $service->deleted = 1;
        $service->save();
        BranchService::where('service_id', $service->id)->update([
            'status' => 0,
            'deleted_at' => Carbon::now(),
            'deleted_by' => Auth::id(),
            'deleted' => 1
        ]);
        return redirect()->back()->with(['success' => 'Service  Deleted Successfully']);
    }

    public function bulkDelete(Request $request)
    {
        Service::whereIn('id', $request->ids)->update([
            'status' => 0,
            'deleted_at' => Carbon::now(),
            'deleted_by' => Auth::id(),
            'deleted' => 1
        ]);

        BranchService::whereIn('service_id', $request->ids)->update([
            'status' => 0,
            'deleted_at' => Carbon::now(),
            'deleted_by' => Auth::id(),
            'deleted' => 1
        ]);
        return redirect()->back()->with(['success' => 'Service  Deleted Successfully']);
    }

    public function serviceImport(Request $request){
        Excel::import(new ServiceImport, $request->file('import_file'));
        return redirect()->back()->with(['success' => 'Service Import Success.']);

    }
}

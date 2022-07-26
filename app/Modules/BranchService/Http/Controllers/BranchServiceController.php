<?php

namespace App\Modules\BranchService\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Branch\Models\Branch;
use App\Modules\BranchService\Models\BranchService;
use App\Modules\Service\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Array_;

class BranchServiceController extends Controller
{
    public function index()
    {

        $common_data = new Array_();
        $common_data->title = 'Branch Service';
        $common_data->page_title = 'Branch Service';
        $branch_services=BranchService::when(myBranchOrNull(),function($q){
            $q->where('branch_id',myBranchOrNull());
        })
        ->where('deleted', 0)->get();
        $branches=Branch::where('deleted',0)->where('status',1)->get();

        $services=Service::where('deleted',0)->where('status',1)->get();


        return view("BranchService::index")
            ->with(compact(
                'common_data',
                'branch_services',
                'branches',
                'services'
            ));
    }

    public function store(Request $request)
    {


        $validator = $request->validate([
            'service_id'=>'required',
            'price'=>'required',
            'discount_type'=>'required',
            'discount_value'=>'nullable',

        ]);
        if (isAdmin()) {
            $request->validate([
                'branch_id'=>'required'
            ]);
        }

        $service=new BranchService();
        $service->branch_id=  requestOrUserBranch($request->branch_id);
        $service->service_id=$request->service_id;
        $service->price=$request->price;
        $service->discount_type=$request->discount_type;
        $service->discount_value=$request->discount_value;
        $service->created_at = Carbon::now();
        $service->created_by = Auth::id();



        $service->save();


        return redirect()->back()->with(['success' => 'Service Added Success']);
    }

    public function edit($id)
    {
        $branch_service=BranchService::find($id);

        $branches=Branch::where('deleted',0)->where('status',1)->get();
        $services=Service::where('deleted',0)->where('status',1)->get();

        if (empty($branch_service)) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid Service'
            ]);
        }

        $view = view("BranchService::_edit_branch_service_data")->with(compact('branch_service','branches','services'))->render();
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
                'service_id'=>'required',
                'price'=>'required',
                'discount_type'=>'required',
                'discount_value'=>'nullable',

            ]);
            if (isAdmin()) {
                $request->validate([
                    'branch_id'=>'required'
                ]);
            }
            $service=BranchService::find($id);
            $validator['branch_id'] = requestOrUserBranch($request->branch_id);

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
            $service = BranchService::where('id', $id)
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
        $user = BranchService::find($id);
        $user->status = 0;
        $user->deleted_at=Carbon::now();
        $user->deleted_by = Auth::id();
        $user->deleted = 1;
        $user->save();

        return redirect()->back()->with(['success' => 'Service  Deleted Successfully']);
    }
    public function bulkDelete(Request $request)
    {
        $product= BranchService::whereIn('id',$request->ids)->update([
            'status' => 0,
            'deleted_at' => Carbon::now(),
            'deleted_by' => Auth::id(),
            'deleted' => 1
        ]);


        if($product){
            return '200';
        }else{
            return '400';
        }
    }

    public function branchServicesList(Request $request){

       /*$service= Service::whereHas('branchService',function($query) use($request){
            return $query->where('branch_id',$request->id)->where('service_id','!=','id');
        })->get();*/

       $services = Service::whereDoesntHave('branchService', function ($q) use ($request) {
           $q->where('branch_id', $request->id)->where('deleted', 0);
       })
           ->where('status', 1)
           ->where('deleted', 0)
           ->get();

       return view('BranchService::_branch_service_list')->with(compact('services'))->render();
    }
}

<?php

namespace App\Modules\Branch\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BankAccount\Models\BankAccount;
use App\Modules\Branch\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;
use PHPUnit\Exception;

class BranchController extends Controller
{
    public function index()
    {
        $common_data = new Array_();
        $common_data->title = 'Branch';
        $common_data->page_title = 'Branch';

        $branches = Branch::where('deleted', 0)->get();
        return view("Branch::index")
            ->with(compact(
                'common_data',
                'branches'
            ));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'note' => 'nullable',
        ]);
        DB::beginTransaction();
        try{
            $data = $validator;
            $data['contact_phone'] = $data['phone'];
            $data['status'] = 1;
            $data['created_at'] = Carbon::now();
            $data['created_by'] = Auth::id();
            $data['deleted'] = 0;

            $branchInfo=Branch::create($data);
            $bankAccount=new BankAccount;
            $bankAccount->branch_id=$branchInfo->id;
            $bankAccount->name='Cash In Hand';
            $bankAccount->account_no= 1000 + $branchInfo->id;
            $bankAccount->opening_balance=0;
            $bankAccount->save();


        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['failed' => $exception->getMessage()]);


        }
        DB::commit();

        return redirect()->back()->with(['success' => 'Branch Added Success']);
    }

    public function edit($id)
    {
        $branch = Branch::where('id', $id)
            ->first();
        if (empty($branch)) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid Branch'
            ]);
        }

        $view = view("Branch::_edit_branch_data")->with(compact('branch'))->render();
        return response()->json([
            'status' => 200,
            'view' => $view
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'note' => 'nullable',
            ]);

            $branch = Branch::where('id', $id)
                ->first();
            if (empty($branch)) {
                return redirect()->back()->with(['failed' => 'Invalid Branch']);
            }
            $data = $validator;
            $data['contact_phone'] = $data['phone'];
            $branch->update($data);

        } catch (\Exception $exception) {
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        return redirect()->back()->with(['success' => 'Branch Update Successs']);
    }

    public function updateStatus($id, $status)
    {
        try {
            $branch = Branch::where('id', $id)
                ->first();
            if (empty($branch)) {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Invalid Branch'
                ]);
            }

            $branch->status = $status;
            $branch->save();
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

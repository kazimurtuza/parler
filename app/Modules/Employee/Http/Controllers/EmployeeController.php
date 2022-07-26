<?php

namespace App\Modules\Employee\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Array_;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $common_data = new Array_();
        $common_data->title = 'Employee';
        $common_data->page_title = 'Employee';


        $employees = Employee::when(myBranchOrNull(), function ($q) {
            $q->where('branch_id', myBranchOrNull());
        })
            ->whereNotIn('type',['admin', 'super_admin'])
            ->where('deleted', 0)
            ->get();

        $branch = Branch::where('deleted', 0)->get();
        $blood_groups = CommonHelper::getBloodGroups();
        return view('Employee::index')->with(compact(
            'common_data',
            'employees',
            'branch',
            'blood_groups'
        ));
    }


    public function store(Request $request)
    {

        $validator = $request->validate([
            'joining_date' => 'required',
            'type' => 'required',
            'salary_type' => 'required',
            'salary_value' => 'required',
            'email' => 'nullable',
            'password' => 'nullable',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'nullable',
            'nid_number' => 'nullable',
            'photo' => 'nullable',
            'dob' => 'nullable',
            'blood' => 'nullable',
            'marital_status' => 'nullable',
            'permanent_address' => 'nullable',
            'employee_id' => 'nullable',
            'contact_person_name' => 'nullable',
            'contact_person_number' => 'nullable',
        ]);

        if (isAdmin()) {
            $request->validate([
                'branch_id' => 'required'
            ]);
        }

        DB::beginTransaction();

        try {
            $countemployee = Employee::count();
            $user = new User();
            $user->role = $request->type;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->status = 1;
            $user->created_at = Carbon::now();
            $user->created_by = Auth::id();
            $user->deleted = 0;
            $user->save();


            $employee = new Employee();

            $employee->branch_id = requestOrUserBranch($request->branch_id);

            $employee->joining_date = $request->joining_date;
            $employee->type = $request->type;
            $employee->user_id = $user->id;
            $employee->salary_type = $request->salary_type;
            $employee->salary_value = $request->salary_value;
            $employee->address = $request->address;
            $employee->nid_number = $request->nid_number;
            if ($request->hasFile('photo')) {
                $name = "employee_" . time() . rand(1000, 9999) . "." . $request->file('photo')->extension();
                $image_url = CommonHelper::uploadFile($request->file('photo'), $name, 'employee');
                $employee->photo = $image_url;
            }
            $employee->dob = $request->dob;
            $employee->blood = $request->blood;
            $employee->gender = $request->gender;
            $employee->marital_status = $request->marital_status;
            $employee->permanent_address = $request->permanent_address;
            $employee->employee_id = $request->branch_id . (100 + $countemployee + 1);
            $employee->contact_person_name = $request->contact_person_name;
            $employee->contact_person_number = $request->contact_person_number;
            $employee->status = 1;
            $employee->created_at = Carbon::now();
            $employee->created_by = Auth::id();
            $employee->deleted = 0;
            $employee->save();

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        DB::commit();


        return redirect()->back()->with(['success' => 'Employee Added Success']);


    }

    public function updateStatus($id, $status)
    {
        try {
            $employee = Employee::where('id', $id)
                ->first();
            if (empty($employee)) {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Invalid Employee'
                ]);
            }

            $employee->status = $status;
            $employee->save();
            return response()->json([
                'status' => 200,
                'updated_status' => $status
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 500,
                'msg' => $exception->getMessage()
            ]);
        }
    }


    public function edit($id)
    {
        $employee = Employee::where('id', $id)
            ->first();
        $branch = Branch::where('deleted', 0)->get();
        if (empty($employee)) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid Employee'
            ]);
        }


        $blood_groups = CommonHelper::getBloodGroups();

        $view = view("Employee::_edit_employee_data")->with(compact(
            'employee',
            'branch',
            'blood_groups'
        ))->render();
        return response()->json([
            'status' => 200,
            'view' => $view
        ]);
    }

    public function details($id)
    {
        $employee = Employee::where('id', $id)
            ->first();
        $branch = Branch::where('deleted', 0)->get();
        if (empty($employee)) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid Employee'
            ]);
        }


        $blood_groups = CommonHelper::getBloodGroups();

        $view = view("Employee::_details_employee_data")->with(compact(
            'employee',
            'branch',
            'blood_groups'
        ))->render();
        return response()->json([
            'status' => 200,
            'view' => $view
        ]);
    }

    public function update(Request $request, $id)
    {

        /*validate request data*/
        $validator = $request->validate([
            'joining_date' => 'required',
            'type' => 'required',
            'salary_type' => 'required',
            'salary_value' => 'required',
            'email' => 'nullable',
            'password' => 'nullable',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'nullable',
            'nid_number' => 'nullable',
            'photo' => 'nullable',
            'dob' => 'nullable',
            'blood' => 'nullable',
            'marital_status' => 'nullable',
            'permanent_address' => 'nullable',
            'contact_person_name' => 'nullable',
            'contact_person_number' => 'nullable',
        ]);

        if (isAdmin()) {
            $request->validate([
                'branch_id' => 'required'
            ]);
        }

        DB::beginTransaction();
        try {
            /*find employee*/
            $employee_data = Employee::find($id);

            /*find user*/
            $user = User::find($employee_data->user->id);

            /*set & save user data*/
            $user->role = $request->type;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->updated_at = Carbon::now();
            $user->updated_by = Auth::id();
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            /*set and save employee data*/
            $employee_data->branch_id = requestOrUserBranch($request->branch_id);
            $employee_data->joining_date = $request->joining_date;
            $employee_data->type = $request->type;
            $employee_data->user_id = $user->id;
            $employee_data->salary_type = $request->salary_type;
            $employee_data->salary_value = $request->salary_value;
            $employee_data->address = $request->address;

            $employee_data->nid_number = $request->nid_number;
            if ($request->hasFile('photo')) {
                $name = "employee_" . time() . rand(1000, 9999) . "." . $request->file('photo')->extension();
                $image_url = CommonHelper::uploadFile($request->file('photo'), $name, 'employee');
                $employee_data->photo = $image_url;
            }
            $employee_data->dob = $request->dob;
            $employee_data->blood = $request->blood;
            $employee_data->gender = $request->gender;
            $employee_data->marital_status = $request->marital_status;
            $employee_data->permanent_address = $request->permanent_address;
//            $employee_data->employee_id=$request->branch_id.(100+$countemployee);
            $employee_data->contact_person_name = $request->contact_person_name;
            $employee_data->contact_person_number = $request->contact_person_number;


            $employee_data->updated_at = Carbon::now();
            $employee_data->updated_by = Auth::id();
            $employee_data->save();

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        DB::commit();
        return redirect()->back()->with(['success' => 'Employee Update Success']);
    }


    public function delete($id)
    {
        /*find employee*/
        $employee_data = Employee::find($id);

        /*find user*/
        $user = User::find($employee_data->user->id);

        $user->status = 0;
        $user->deleted_at = Carbon::now();
        $user->deleted_by = Auth::id();
        $user->deleted = 1;
        $user->save();


        $employee_data->status = 0;
        $employee_data->deleted_at = Carbon::now();
        $employee_data->deleted_by = Auth::id();
        $employee_data->deleted = 1;
        $employee_data->save();
        return redirect()->back()->with(['success' => 'Employee Deleted Successfully']);
    }

    public function bulkDelete( Request $request)
    {
         Employee::whereIn('id',$request->ids)->update([
            'status' => 0,
            'deleted_at' => Carbon::now(),
            'deleted_by' => Auth::id(),
            'deleted' => 1
        ]);

         foreach ($request->ids as $empid){
             $user_id=Employee::find($empid)->user_id;
             $user=User::find($user_id);
             $user->status = 0;
             $user->deleted_at = Carbon::now();
             $user->deleted_by = Auth::id();
             $user->deleted = 1;
             $user->save();
         }


        /*find user*/
//       $user_data = User::whereHas('employee', function ($q) use ($request) {
//           $q->whereIn('employee.id', $request->ids);
//       })->update([
//           'status' => 0,
//           'deleted_at' => Carbon::now(),
//           'deleted_by' => Auth::id(),
//           'deleted' => 1
//       ]);

//      return  DB::table('users')->join('employees','users.id','=','employees.user_id')->select('employees.user_id')->whereIn('employees.user_id',$request->ids)->get()->toArray();


        return ['200'=>'success'];

//        return redirect()->back()->with(['success' => 'Employee Deleted Successfully']);
    }

}

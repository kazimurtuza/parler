<?php

namespace App\Modules\BankAccount\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BankAccount\Models\BankAccount;
use App\Modules\Branch\Models\Branch;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;

class BankAccountController extends Controller
{
    public function index()
    {
        $common_data = new Array_();
        $common_data->title = 'Bank Accounts';
        $common_data->page_title = 'Bank Accounts';
        $bankAccounts = BankAccount::when(myBranchOrNull(), function ($q) {
            $q->where('branch_id', myBranchOrNull());
        })
            ->where('deleted', 0)->get();
        $branches = Branch::where('deleted', 0)->get();
        return view('BankAccount::index')->with(compact(
            'branches',
            'bankAccounts',
            'common_data'
        ));
    }

    public function store(Request $request)
    {
        $bankAccount = new BankAccount;
        $bankAccount->branch_id = requestOrUserBranch($request->branch_id);
        $bankAccount->name = $request->name;
        $bankAccount->account_no = $request->account_no;
        $bankAccount->opening_balance = $request->opening_balance;
        $bankAccount->save();
        return redirect()->back()->with('success', 'Bank Account Successfully Created');
    }

    public function edit($id)
    {
        $bankAccounts = BankAccount::where('id', $id)->first();
        $branches = Branch::where('deleted', 0)->get();
        $view = view('BankAccount::_edit_bank_account')->with(compact('bankAccounts', 'branches'))->render();

        return response()->json([
            'status' => 200,
            'view' => $view
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'branch_id' => 'nullable',
            'name' => 'required',
            'account_no' => 'required',
            'opening_balance' => 'required',

        ]);
        $bank_AC = BankAccount::find($id);
        if (!isAdmin()) {
            $validate['branch_id'] = myBranchId();
        }
        $bank_AC->update($validate);
        return redirect()->back()->with('success', 'Bank Account Successfully Updated');
    }
}

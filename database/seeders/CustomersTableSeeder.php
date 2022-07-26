<?php

namespace Database\Seeders;

use App\Modules\CustomerMembership\Models\CustomerMembership;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer_membership = CustomerMembership::where('status', 1)->first();
        if (empty($customer_membership)) {
            $cm_id = null;
        } else {
            $cm_id = $customer_membership->id;
        }
        DB::table('customers')->insert([
            'id' => 1,
            'branch_id' => null,
            'customer_membership_id' => $cm_id,
            'first_name' => 'Walk In',
            'last_name' => 'Customer',
            'email' => 'wic@alviras.com',
            'phone' => '01000000',
            'photo' => null,
            'dob' => null,
            'gender' => 0,
            'blood' => null,
            'address' => 'Alvira',
            'available_balance' => 0,
            'can_due' => 0,
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1,
            'deleted' => 0,
        ]);
    }
}

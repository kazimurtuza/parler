<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'role' => 'super_admin',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@example.com',
            'phone' => '01900000001',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('123456'),
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1,
            'deleted' => 0
        ]);

        DB::table('employees')->insert([
            'type' => 'super_admin',
            'user_id' => 1,
            'branch_id' => null,
            'salary_type' => 1,
            'salary_value' => 0,
            'joining_date' => Carbon::now(),
            'gender' => '0',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1,
            'deleted' => 0
        ]);


        DB::table('users')->insert([
            'id' => 2,
            'role' => 'admin',
            'first_name' => 'System',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '01900000000',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('123456'),
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1,
            'deleted' => 0
        ]);


        DB::table('employees')->insert([
            'type' => 'admin',
            'user_id' => 2,
            'branch_id' => null,
            'salary_type' => 1,
            'salary_value' => 0,
            'joining_date' => Carbon::now(),
            'gender' => '0',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1,
            'deleted' => 0
        ]);
    }
}

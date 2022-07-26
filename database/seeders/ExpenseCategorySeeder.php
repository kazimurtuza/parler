<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseCategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('expense_categories')->insert([
            'id' => 1,
            'name' => 'Purchase',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1,
            'deleted' => 0
        ]);
        DB::table('expense_sub_categories')->insert([
            'id' => 1,
            'expense_category_id' => 1,
            'name' => 'Beauty Parler Product Purchase',
            'status' => 1,
            'is_product_purchase' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1,
            'deleted' => 0
        ]);
    }
}

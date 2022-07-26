<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsProductPurchaseColumnInExpenseSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expense_sub_categories', function (Blueprint $table) {
            $table->tinyInteger('is_product_purchase')->after('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expense_sub_categories', function (Blueprint $table) {
            $table->dropColumn('is_product_purchase');
        });
    }
}

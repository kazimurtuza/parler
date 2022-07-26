<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('total_qty')->default(0);
            $table->unsignedInteger('used_qty')->default(0);
            $table->unsignedInteger('available_qty')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch_products');
    }
}

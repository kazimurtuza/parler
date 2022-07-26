<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRequisitionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_requisition_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('product_requisition_id')->comment('id from product_requisitions table');
            $table->unsignedInteger('product_id')->comment('id from products table');
            $table->decimal('unit_price', 10,2)->default(0);
            $table->integer('quantity')->default(1);
            $table->decimal('total_amount', 10,2)->default(0);

            $table->tinyInteger('status')->default(1)->comment('0=inactive,1=active');
            $table->timestamp('created_at')->nullable()->default(null);
            $table->unsignedInteger('created_by')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->unsignedInteger('updated_by')->nullable()->default(null);
            $table->tinyInteger('deleted')->default(0)->comment('0=active,1=deleted');
            $table->timestamp('deleted_at')->nullable()->default(null);
            $table->unsignedInteger('deleted_by')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_requisition_details');
    }
}

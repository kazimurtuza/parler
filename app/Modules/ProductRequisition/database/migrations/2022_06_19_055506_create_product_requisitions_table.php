<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('requisition_no', 32)->nullable();
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('requested_by');
            $table->decimal('total_amount',10,2)->default(0);
            $table->tinyInteger('approve_status')->default(0)->comment('0=pending,1=approved,2=rejected/declined,3=purchased');
            $table->unsignedInteger('approve_by')->nullable();

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
        Schema::dropIfExists('product_requisitions');
    }
}

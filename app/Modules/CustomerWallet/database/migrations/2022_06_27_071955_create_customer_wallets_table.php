<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('customer_id');
            $table->string('transaction_no', 32)->nullable();
            $table->string('type', 8)->default('out')->comment('in,out');
            $table->string('type_description', 128)->nullable();
            $table->unsignedInteger('branch_id')->nullable();
            $table->timestamp('datetime')->nullable();
            $table->decimal('amount',10,2)->default(0);

            $table->text('note')->nullable();

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
        Schema::dropIfExists('customer_wallets');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceColumnInCustomerWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_wallets', function (Blueprint $table) {
            $table->string('reference',255)->nullable()->after('type_description');
            $table->unsignedInteger('reference_id')->nullable()->after('reference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_wallets', function (Blueprint $table) {
            $table->dropColumn('reference');
            $table->dropColumn('reference_id');
        });
    }
}

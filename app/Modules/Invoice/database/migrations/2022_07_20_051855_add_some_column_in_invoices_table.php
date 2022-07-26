<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnInInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('previous_wallet_balance', 10,2)->default(0)->nullable()->after('payable_amount');
            $table->unsignedInteger('payment_method')->nullable()->after('previous_wallet_balance');
            $table->decimal('paid_amount', 10,2)->default(0)->nullable()->after('payment_method');
            $table->decimal('new_wallet_balance', 10,2)->default(0)->nullable()->after('paid_amount');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('previous_wallet_balance');
            $table->dropColumn('payment_method');
            $table->dropColumn('paid_amount');
            $table->dropColumn('new_wallet_balance');
        });
    }
}

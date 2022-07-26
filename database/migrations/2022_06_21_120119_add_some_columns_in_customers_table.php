<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnsInCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('phone');
            $table->date('dob')->nullable()->after('photo');
            $table->integer('gender')->nullable()->after('dob');
            $table->string('blood')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('photo');
            $table->dropColumn('dob');
            $table->dropColumn('gender');
            $table->dropColumn('blood');
        });
    }
}

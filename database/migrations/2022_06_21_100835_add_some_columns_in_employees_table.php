<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnsInEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('nid_number', 32)->nullable()->after('joining_date');
            $table->string('photo', 255)->nullable()->after('nid_number');
            $table->date('dob')->nullable()->after('photo');
            $table->string('blood')->nullable()->after('dob');
            $table->tinyInteger('gender')->default(0)->after('blood')->comment('0=male,1=female,2=others');
            $table->string('marital_status')->nullable()->after('gender');
            $table->string('permanent_address')->nullable()->after('marital_status');
            $table->string('employee_id')->nullable()->after('permanent_address');
            $table->string('contact_person_name')->nullable()->after('employee_id');
            $table->string('contact_person_number')->nullable()->after('contact_person_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('nid_number');
            $table->dropColumn('photo');
            $table->dropColumn('dob');
            $table->dropColumn('blood');
            $table->dropColumn('gender');
            $table->dropColumn('marital_status');
            $table->dropColumn('permanent_address');
            $table->dropColumn('employee_id');
            $table->dropColumn('contact_person_name');
            $table->dropColumn('contact_person_number');
        });
    }
}

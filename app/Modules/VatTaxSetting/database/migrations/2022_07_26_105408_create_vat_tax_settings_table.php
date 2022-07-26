<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVatTaxSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vat_tax_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title',128);
            $table->decimal('vat_percent',11,2);
            $table->decimal('maximum_amount',11,2);
            $table->tinyInteger('is_default')->default(0)->comment('default_selected=1');
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
        Schema::dropIfExists('vat_tax_settings');
    }
}

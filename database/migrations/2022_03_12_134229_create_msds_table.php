<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msds', function (Blueprint $table) {
            $table->id();
            $table->integer('departement_id')->constrained('departements', 'id');
            $table->string('chemical_common_name');
            $table->string('trade_name');
            $table->integer('hsno_class');
            $table->date('sds_issue_date');
            $table->date('expired_date');
            $table->string('un_number');
            $table->string('cas_number');
            $table->string('chemical_supplier');
            $table->integer('quantity_volume');
            $table->string('concentration');
            $table->string('packaging_size');
            $table->string('type_of_container');
            $table->string('location_of_chemical');
            $table->string('bulk_storage_tank');
            $table->string('signage_in_place');
            $table->string('bund_capacity');
            $table->string('bunding_material');
            $table->string('comments_other');
            $table->text('path_pdf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('msds');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEmailNotify extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_email_notify', function (Blueprint $table) {
            $table->id();
            $table->integer('departement_id')->constrained('departements', 'id');
            $table->integer('msds_id')->constrained('msds', 'id');
            $table->integer('7day')->default(0);
            $table->integer('3day')->default(0);
            $table->integer('1day')->default(0);
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
        Schema::dropIfExists('table_email_notify');
    }
}

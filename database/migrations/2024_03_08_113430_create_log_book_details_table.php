<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogBookDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_book_details', function (Blueprint $table) {
            $table->id();
            $table->string('no_medis');
            $table->string('kunjungan');
            $table->string('diagnosis');
            $table->string('diagnosis_banding');
            $table->string('terapi');
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
        Schema::dropIfExists('log_book_details');
    }
}

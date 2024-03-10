<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pivot_semesters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('semesters_id');
            $table->unsignedBigInteger('users_id');
            $table->timestamps();

            $table->foreign('semesters_id')->references('id')->on('semesters')->onDelete('CASCADE');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pivot_semesters');
    }
}

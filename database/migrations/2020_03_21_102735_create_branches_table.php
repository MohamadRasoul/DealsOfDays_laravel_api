<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();

            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();

            $table->integer('view')->default(0);
            $table->string('openAt_closeAt');
            $table->string('description')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();

            $table->foreignId('company_id');
            $table->foreignId('user_id');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
}

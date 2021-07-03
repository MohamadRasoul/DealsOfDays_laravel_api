<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('descreption');
            $table->integer('offerPrecentage')->nullable();
            $table->double('oldPrice')->nullable();
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->double('rating')->default(0);
            $table->integer('views')->default(0);
            $table->string('url')->nullable();
            $table->boolean('isOnline')->default(false);
            $table->string('copon')->nullable();
            $table->string('curency')->default('SY');
            $table->Boolean('allBranches')->default(false);
            $table->Boolean('proirity')->default(false);
            $table->timestamps();

            $table->foreignId('category_id');
            $table->foreignId('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}

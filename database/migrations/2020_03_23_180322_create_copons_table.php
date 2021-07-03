<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copons', function (Blueprint $table) {
            $table->id();
            $table->string('copon')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreignId('user_id');
            $table->foreignId('offer_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            
            $table->unique(['user_id', 'offer_id']);
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('copons');
    }
}

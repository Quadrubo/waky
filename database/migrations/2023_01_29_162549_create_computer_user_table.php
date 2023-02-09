<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computer_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('computer_id')->unsigned()->constrained()->cascadeOnDelete();
            $table->bigInteger('user_id')->unsigned()->constrained()->cascadeOnDelete();

            $table->unique(['computer_id', 'user_id']);
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
        Schema::dropIfExists('computer_user');
    }
};

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
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mac_address');
            $table->string('ip_address');
            $table->string('status')->nullable();
            $table->dateTime('status_updated_at')->nullable();

            $table->string('ssh_user')->nullable();
            $table->string('ssh_shutdown_command')->nullable();

            $table->foreignId('s_s_h_key_id')->nullable()->constrained('s_s_h_keys')->nullOnDelete();

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
        Schema::dropIfExists('computers');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id')->unsigned(); // sender
            $table->integer('medic_id')->unsigned();  // receiver
            $table->string('status');
            $table->string('description')->nullable();
            $table->timestamp('date_responded')->nullable();  
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
        Schema::dropIfExists('send_requests');
    }
}

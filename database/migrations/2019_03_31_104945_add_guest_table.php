<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGuestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->boolean('plus1')->default(false);
            $table->string('plus1name')->nullable();
            $table->boolean('receptie')->default(false);
            $table->boolean('diner')->default(false);
            $table->boolean('feest')->default(false);
            $table->boolean('RSVP')->default(false);
            $table->boolean('responded')->default(false);
            $table->boolean('veggie')->default(false);
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
        Schema::drop('guests');
    }
}

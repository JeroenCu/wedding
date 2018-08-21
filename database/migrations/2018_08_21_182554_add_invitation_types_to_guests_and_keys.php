<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvitationTypesToGuestsAndKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->string('hash');
        });
        Schema::create('invitationTypesPerGuest', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('hash');
            $table->boolean('reception')->default(false);
            $table->boolean('dinner')->default(false);
            $table->boolean('dessert')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keys');
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn('hash');
        });
    }
}

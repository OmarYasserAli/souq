<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialmediaAndBioAndVerificationToSellers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->text('bio');
            $table->string('facebook');
            $table->string('active_facebook');
            $table->string('twitter');
            $table->tinyInteger('active_twitter');
            $table->string('instagram');
            $table->tinyInteger('active_instagram');
            $table->string('tiktok');
            $table->tinyInteger('active_tiktok');
            $table->tinyInteger('active_whatsapp');
            $table->string('verification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sellers', function (Blueprint $table) {
            //
        });
    }
}

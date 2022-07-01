<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('logo', 100);
            $table->string('favicon', 100);
            $table->string('email', 100);
            $table->string('mobile', 11);
            $table->string('fb_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->unsignedBigInteger('create_by');
            $table->timestamps();
            $table->foreign('create_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}

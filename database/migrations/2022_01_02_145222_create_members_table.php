<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_id', 20)->unique();
            $table->string('name', 50);
            $table->enum('gender', ['male', 'female']);
            $table->string('mobile', 11)->unique();
            $table->enum('blood_group', ['A+', 'A-', 'AB+', 'AB-', 'B+', 'B-', 'O+', 'O-']);
            $table->text('address');
            $table->string('photo', 100);
            $table->tinyInteger('lock')->default(0);
            $table->string('card_no', 15)->default('0000000000');
            $table->unsignedBigInteger('create_by');
            $table->enum('status', ['active', 'expired', 'locked', 'limited'])->default('expired');
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
        Schema::dropIfExists('members');
    }
}

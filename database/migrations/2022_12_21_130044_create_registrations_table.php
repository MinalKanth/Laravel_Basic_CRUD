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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('dob')->nullable();
            $table->text('des')->nullable();
            $table->string('qua')->nullable();
            $table->string('email');
            $table->string('mo');
            $table->string('gender')->nullable();
            $table->boolean('is_relocate');
            $table->foreignId('country')->nullable();
            $table->foreignId('state')->nullable();
            $table->foreignId('city')->nullable();
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
        Schema::dropIfExists('registrations');
    }
};

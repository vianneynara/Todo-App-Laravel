<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id('todo_id');
            $table->unsignedBigInteger('user_id');
            $table->text('description');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();

            //foreign key that references todo to user
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('todos');
    }
};
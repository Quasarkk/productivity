<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Crée une colonne user_id pour stocker l'ID de l'utilisateur

            $table->string('name');
            $table->dateTime('dates')->nullable();

            $table->time('begin_hour')->nullable();
            $table->time('end_hour')->nullable();

            $table->enum('status', ['done', 'not done'])->default('not done');
            $table->unsignedBigInteger('taskable_id')->nullable(); // For polymorphic relation
            $table->string('taskable_type')->nullable(); // For polymorphic relation
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}


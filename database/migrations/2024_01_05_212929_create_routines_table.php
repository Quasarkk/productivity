<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subobjective_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('when', ['morning', 'noon', 'afternoon', 'evening']);
            $table->timestamps();

            $table->foreign('subobjective_id')->references('id')->on('subobjectives');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routines');
    }
};

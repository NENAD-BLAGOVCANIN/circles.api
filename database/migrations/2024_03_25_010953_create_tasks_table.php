<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('description')->nullable();;
            $table->foreignId('lead_id')->nullable();
            $table->unsignedBigInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');            
            $table->unsignedBigInteger('assignedTo');
            $table->foreign('assignedTo')->references('id')->on('users')->onDelete('cascade');            
            $table->timestamps();
            $table->boolean('is_deleted')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unique();
            $table->text('content');
            $table->boolean('is_sent')->default(false);
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamps();
            
            $table->index(['is_sent', 'last_sent_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};

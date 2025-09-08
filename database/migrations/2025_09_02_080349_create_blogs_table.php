<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id(); // BIGINT AUTO_INCREMENT PRIMARY KEY
            $table->string('title', 255); // Title
            $table->text('content');      // Content
            $table->string('author', 255); // Author's Name
            $table->string('image', 255)->nullable(); // Image path or URL
            $table->enum('category', ['News', 'Education', 'Other'])->nullable(); // Category
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};

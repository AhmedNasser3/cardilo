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
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();

            // Searches
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->fullText(['name', 'description']);
            $table->json('metadata')->nullable();
            $table->integer('set_order')->default(0);
            $table->string('image')->nullable()->index();

            // RELATIONS
            $table->uuid('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // status
            $table->boolean('is_active')->default(true);
            $table->timestamp('publish_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');

    }
};

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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();

            // data
            $table->string('name')->index();
            $table->string('description')->index()->nullable();
            $table->fullText(['name', 'description']);
            $table->integer('set_order')->default(0);
            $table->string('image')->nullable()->index();
            $table->json('metadata')->nullable();
            // RelationShips
            $table->uuid('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();

            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();

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
        Schema::dropIfExists('sub_categories');
    }
};
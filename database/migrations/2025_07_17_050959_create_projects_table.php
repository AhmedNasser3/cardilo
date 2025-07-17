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
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('slug')->unique();

            // RelationShip
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('subcategory_id')->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->cascadeOnDelete();

            // data
            $table->string('name')->index();
            $table->text('description');
            $table->fullText(['name', 'description']);
            $table->json('metadata')->nullable();
            $table->json('skills')->nullable();
            $table->json('attachments')->nullable();
            $table->decimal('price', 10, 2);
            $table->check('price >= 0');
            $table->integer('deadline');
            $table->integer('set_order')->default(0);

            // status
            $table->enum('status', ['Active', 'preview', 'progressing', 'cancelled', 'closed']);
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
        Schema::dropIfExists('projects');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('email')->unique()->index();
            $table->enum('role', ['admin', 'user'])->default('user')->index();
            $table->enum('status', [
                'active',
                'pending',
                'suspended',
                'banned',
                'inactive',
                'archived'
            ])->default('pending')->index();
            $table->timestamp('last_login_at')->nullable()->index();
            $table->integer('login_count')->default(0)->index();
            $table->string('avatar')->nullable();
            $table->boolean('notifications_enabled')->default(true);
            $table->enum('notification_type', ['email', 'sms', 'push'])->default('email');
            $table->string('badges')->nullable()->index();
            $table->json('permissions')->nullable();
            $table->json('session_history')->nullable();
            $table->softDeletes()->index();
            $table->integer('order')->default(0)->index();
            $table->timestamp('email_verified_at')->nullable()->index();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable()->index();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable()->index();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable()->index();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

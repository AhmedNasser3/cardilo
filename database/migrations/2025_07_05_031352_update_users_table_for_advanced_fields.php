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
        Schema::table('users', function (Blueprint $table) {
            // 🧩 Role
            $table->enum('role', ['admin', 'user'])->default('user')->after('email');

            // 🔵 الحالة
            $table->enum('status', [
                'active',
                'pending',
                'suspended',
                'banned',
                'inactive',
                'archived'
            ])->default('pending')->after('role');

            // 🔵 آخر دخول
            $table->timestamp('last_login_at')->nullable()->after('status');

            // 🔵 عدد مرات الدخول
            $table->integer('login_count')->default(0)->after('last_login_at');

            // 🔵 الصورة الرمزية
            $table->string('avatar')->nullable()->after('login_count');

            // 🔔 استقبال إشعارات
            $table->boolean('notifications_enabled')->default(true)->after('avatar');

            // 🔔 نوع الإشعارات
            $table->enum('notification_type', ['email', 'sms', 'push'])->default('email')->after('notifications_enabled');

            // 🏅 Badges (أوسمة)
            $table->string('badges')->nullable()->after('notification_type');

            // 📝 Permissions (json)
            $table->json('permissions')->nullable()->after('badges');

            // 📜 Session history (json)
            $table->json('session_history')->nullable()->after('permissions');

            // 🗑️ Soft Deletes
            $table->softDeletes()->after('session_history');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'status',
                'last_login_at',
                'login_count',
                'avatar',
                'notifications_enabled',
                'notification_type',
                'badges',
                'permissions',
                'session_history',
                'deleted_at',
            ]);
        });
    }
};
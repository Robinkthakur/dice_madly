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
        // 1. Users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_id')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('phone')->nullable()->change();
        });

        // 2. Educations table
        Schema::table('educations', function (Blueprint $table) {
            $table->string('highest_qualification')->nullable()->change();
        });

        // 3. Occupations table
        Schema::table('occupations', function (Blueprint $table) {
            $table->string('occupation')->nullable()->change();
        });

        // 4. Packages table
        Schema::table('packages', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->nullable()->change();
            $table->integer('duration_days')->default(30)->nullable()->change();
            $table->integer('contact_limit')->default(0)->nullable()->change();
            $table->integer('interest_limit')->default(0)->nullable()->change();
            $table->boolean('chat_access')->default(false)->change();
            $table->boolean('view_contact')->default(false)->change();
        });

        // 5. Companion rentals table
        if (Schema::hasTable('companion_rentals')) {
            Schema::table('companion_rentals', function (Blueprint $table) {
                $table->string('gender')->nullable()->change();
                $table->string('phone')->nullable()->change();
            });
        }

        // 6. Matches table
        Schema::table('matches', function (Blueprint $table) {
            $table->decimal('match_percentage', 5, 2)->default(0)->nullable()->change();
        });

        // 7. Subscriptions table
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();
            $table->string('status')->default('Active')->nullable()->change();
        });

        // 8. Payments table
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id')->nullable()->change();
            $table->string('transaction_id')->nullable()->change();
            $table->decimal('amount', 10, 2)->default(0)->nullable()->change();
            $table->string('gateway')->default('manual')->nullable()->change();
            $table->string('status')->default('Pending')->nullable()->change();
        });

        // 9. Reports table
        Schema::table('reports', function (Blueprint $table) {
            $table->text('reason')->nullable()->change();
        });

        // 10. User logs table
        Schema::table('user_logs', function (Blueprint $table) {
            $table->string('action')->nullable()->change();
        });

        // 11. Notifications table
        if (Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->string('title')->nullable()->change();
                $table->text('message')->nullable()->change();
                $table->string('type')->default('general')->nullable()->change();
            });
        }

        // 12. Admins table
        if (Schema::hasTable('admins')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->string('password')->nullable()->change();
            });
        }

        // 13. Verifications table
        Schema::table('verifications', function (Blueprint $table) {
            $table->string('type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_id')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
        });

        Schema::table('educations', function (Blueprint $table) {
            $table->string('highest_qualification')->nullable(false)->change();
        });

        Schema::table('occupations', function (Blueprint $table) {
            $table->string('occupation')->nullable(false)->change();
        });

        Schema::table('matches', function (Blueprint $table) {
            $table->decimal('match_percentage', 5, 2)->nullable(false)->change();
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->text('reason')->nullable(false)->change();
        });

        Schema::table('user_logs', function (Blueprint $table) {
            $table->string('action')->nullable(false)->change();
        });

        Schema::table('verifications', function (Blueprint $table) {
            $table->string('type')->nullable(false)->change();
        });
    }
};

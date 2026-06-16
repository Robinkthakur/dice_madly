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
        // 1. Add onboarding_step to users table if not exists
        if (!Schema::hasColumn('users', 'onboarding_step')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('onboarding_step')->default('bio_dp')->after('password');
            });
        }

        // 2. Modify verifications table: add id_type
        if (!Schema::hasColumn('verifications', 'id_type')) {
            Schema::table('verifications', function (Blueprint $table) {
                $table->string('id_type')->nullable()->after('type');
            });
        }

        // 3. Create interest_options table
        if (!Schema::hasTable('interest_options')) {
            Schema::create('interest_options', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('category');
                $table->timestamps();
            });
        } else {
            if (!Schema::hasColumn('interest_options', 'category')) {
                Schema::table('interest_options', function (Blueprint $table) {
                    $table->string('category')->after('name');
                });
            }
        }

        // 4. Create user_interest_options pivot table
        if (!Schema::hasTable('user_interest_options')) {
            Schema::create('user_interest_options', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('interest_option_id')->constrained('interest_options')->onDelete('cascade');
                $table->primary(['user_id', 'interest_option_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_interest_options');
        Schema::dropIfExists('interest_options');

        if (Schema::hasColumn('verifications', 'id_type')) {
            Schema::table('verifications', function (Blueprint $table) {
                $table->dropColumn('id_type');
            });
        }

        if (Schema::hasColumn('users', 'onboarding_step')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('onboarding_step');
            });
        }
    }
};

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
        if (!Schema::hasColumn('users', 'daily_rolls_count')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('daily_rolls_count')->default(0)->after('onboarding_step');
            });
        }

        if (!Schema::hasColumn('users', 'last_roll_date')) {
            Schema::table('users', function (Blueprint $table) {
                $table->date('last_roll_date')->nullable()->after('daily_rolls_count');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'daily_rolls_count')) {
                $table->dropColumn('daily_rolls_count');
            }
            if (Schema::hasColumn('users', 'last_roll_date')) {
                $table->dropColumn('last_roll_date');
            }
        });
    }
};

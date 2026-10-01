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
        Schema::create('companion_rentals', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->enum('type', ['client', 'partner'])->default('client')->comment('client = Looking to rent, partner = Register as companion');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->enum('rent_target', ['boyfriend', 'girlfriend', 'both'])->default('girlfriend')->comment('Target companion or service offering');
            $table->integer('age')->nullable();
            $table->string('city')->nullable();
            $table->string('duration_hours')->nullable()->comment('Requested hours or partner availability');
            $table->string('budget_or_rate')->nullable()->comment('Client budget or Partner hourly expectation');
            $table->text('hobbies_interests')->nullable();
            $table->text('partner_experience')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['pending', 'contacted', 'approved', 'rejected', 'completed'])->default('pending');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index('reference_no');
            $table->index('type');
            $table->index('rent_target');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companion_rentals');
    }
};

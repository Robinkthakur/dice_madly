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
        Schema::create('partner_preferences', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')->constrained();

            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();

            $table->string('religion')->nullable();
            $table->string('caste')->nullable();

            $table->string('country')->nullable();

            $table->decimal('min_income',12,2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

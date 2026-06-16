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
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('action');

            $table->string('module')->nullable();

            $table->text('description')->nullable();

            $table->string('ip_address', 45)->nullable();

            $table->string('user_agent')->nullable();

            $table->string('device_type')->nullable();

            $table->string('platform')->nullable();

            $table->string('browser')->nullable();

            $table->json('old_values')->nullable();

            $table->json('new_values')->nullable();

            $table->json('meta')->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('action');
            $table->index('module');
            $table->index('created_at');
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

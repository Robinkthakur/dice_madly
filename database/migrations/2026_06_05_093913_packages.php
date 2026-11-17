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
        Schema::create('packages', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->decimal('price',10,2)->default(0)->nullable();

            $table->integer('duration_days')->default(30)->nullable();

            $table->integer('contact_limit')->default(0)->nullable();

            $table->integer('interest_limit')->default(0)->nullable();

            $table->boolean('chat_access')->default(false);

            $table->boolean('view_contact')->default(false);

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

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
        Schema::create('notebooks', function(Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable(false);
            $table->string('company_name')->nullable();
            $table->string('phone')->nullable(false);
            $table->string('email')->nullable(false);
            $table->date('birthday')->nullable();
            $table->string('photo_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('notebooks');
    }
};

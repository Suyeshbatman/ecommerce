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
        Schema::create('user_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('normaluser_id');
            $table->unsignedBigInteger('availability_id');
            $table->Date('requesteddate');
            $table->Time('requestedtime');
            $table->String('requested');
            $table->String('accepted');
            $table->Time('jobstarttime');
            $table->Time('jobendtime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_carts');
    }
};

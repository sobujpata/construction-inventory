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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('email', 100)->uniqid();
            $table->string('mobile', 20);
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('village')->nullable();
            $table->string('present_address', 200)->nullable();
            $table->string('image')->nullable();

            $table->foreign('division_id')->references('id')->on('divisions')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('district_id')->references('id')->on('districts')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('upazila_id')->references('id')->on('upazilas')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('union_id')->references('id')->on('unions')->cascadeOnUpdate()->restrictOnDelete();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

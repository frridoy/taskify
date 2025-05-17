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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('notice_type');
            $table->json('notice_for');
            $table->string('reference_no')->unique()->nullable();
            $table->dateTime('meeting_date_time')->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->tinyInteger('is_active');
            $table->unsignedBigInteger('authorized_by')->nullable();
            $table->foreign('authorized_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};

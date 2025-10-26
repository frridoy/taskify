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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('employment_type', ['full-time', 'part-time', 'contract', 'remote']);
            $table->integer('vacancies')->unsigned();
            $table->integer('age_limit')->unsigned()->nullable();
            $table->enum('sex', ['male', 'female', 'any'])->default('any');
            $table->decimal('salary_min', 12, 2);
            $table->decimal('salary_max', 12, 2)->nullable();
            $table->decimal('application_fee', 10, 2)->default(0);
            $table->dateTime('application_start_date');
            $table->dateTime('application_end_date');
            $table->boolean('is_active')->default(1);
            $table->text('description')->nullable();
            $table->string('exp_min')->nullable();
            $table->string('exp_max')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};

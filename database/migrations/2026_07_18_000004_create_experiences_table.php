<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table): void {
            $table->id();
            $table->string('key', 96)->unique();

            $table->string('company_ar');
            $table->string('company_en');
            $table->string('role_ar');
            $table->string('role_en');
            $table->string('location_ar', 160)->nullable();
            $table->string('location_en', 160)->nullable();

            $table->date('start_date');
            // Null end_date plus is_current is what renders as "Present".
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);

            $table->text('summary_ar')->nullable();
            $table->text('summary_en')->nullable();
            $table->json('highlights_ar')->nullable();
            $table->json('highlights_en')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};

<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table): void {
            $table->id();
            $table->string('key', 96)->unique();
            $table->string('icon', 64)->default('knife');

            $table->string('title_ar');
            $table->string('title_en');
            $table->string('summary_ar', 500);
            $table->string('summary_en', 500);
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->json('features_ar')->nullable();
            $table->json('features_en')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

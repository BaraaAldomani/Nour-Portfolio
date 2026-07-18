<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education_items', function (Blueprint $table): void {
            $table->id();
            $table->string('key', 96)->unique();

            $table->string('institution_ar');
            $table->string('institution_en');
            $table->string('credential_ar');
            $table->string('credential_en');
            $table->string('field_ar', 190)->nullable();
            $table->string('field_en', 190)->nullable();
            $table->string('grade_ar', 96)->nullable();
            $table->string('grade_en', 96)->nullable();

            $table->date('completed_on')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('education_items');
    }
};

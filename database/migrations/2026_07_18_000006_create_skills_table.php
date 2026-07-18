<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table): void {
            $table->id();
            $table->string('key', 96)->unique();

            $table->string('name_ar', 190);
            $table->string('name_en', 190);

            // Matches App\Enums\SkillCategory.
            $table->string('category', 32)->default('culinary');
            // 1-5, rendered as a discreet meter rather than a percentage.
            $table->unsignedTinyInteger('level')->default(4);

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['category', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};

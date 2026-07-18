<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('process_steps', function (Blueprint $table): void {
            $table->id();
            $table->string('key', 96)->unique();

            $table->string('title_ar');
            $table->string('title_en');
            $table->text('description_ar');
            $table->text('description_en');

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('process_steps');
    }
};

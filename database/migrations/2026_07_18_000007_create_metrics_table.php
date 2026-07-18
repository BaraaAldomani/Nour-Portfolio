<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metrics', function (Blueprint $table): void {
            $table->id();
            $table->string('key', 96)->unique();

            $table->unsignedInteger('value');
            $table->string('suffix', 8)->nullable();

            $table->string('label_ar', 190);
            $table->string('label_en', 190);

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metrics');
    }
};

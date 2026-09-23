<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title_en', 300)->nullable();
            $table->string('title_ar', 300)->nullable();
            $table->string('subtitle_en', 500)->nullable();
            $table->string('subtitle_ar', 500)->nullable();
            $table->string('image', 2000);
            $table->string('link', 2000)->nullable();
            $table->string('button_text_en', 100)->default('Discover Now');
            $table->string('button_text_ar', 100)->default('اكتشف الآن');
            $table->enum('position', ['hero', 'promo'])->default('hero');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};

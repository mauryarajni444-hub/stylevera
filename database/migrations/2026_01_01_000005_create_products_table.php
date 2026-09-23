<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name_en', 500);
            $table->string('name_ar', 500);
            $table->string('slug', 600)->unique();
            $table->string('short_desc_en', 1000)->nullable();
            $table->string('short_desc_ar', 1000)->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_ar')->nullable();
            $table->decimal('base_price', 10, 2)->default(0);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('sku', 100)->nullable();
            $table->string('cover_image', 2000)->nullable();
            $table->enum('gender', ['men', 'women', 'unisex', 'kids'])->default('unisex');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->integer('views')->default(0);
            $table->decimal('rating', 3, 1)->default(0.0);
            $table->integer('reviews_count')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('home_announcement', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('country');
            $table->decimal('price-for-night');
            $table->integer('num_rooms');
            $table->integer('num_bathrooms');
            $table->integer('square_meters');
            $table->integer('max_guests');
            $table->json('amenities'); // JSON o text, per elencare servizi come 'wifi', 'cucina', 'parcheggio', ecc. JSON è più flessibile)
            $table->string('main_image_path');
            $table->json('additional_image_paths');
            $table->date('availability_start_date');
            $table->date('availability_end_date');
            $table->boolean('is_active');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_announcement');
    }
};

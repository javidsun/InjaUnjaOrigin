<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_announcement', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relazioni
            $table->foreignUlid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('location_id')->constrained(); // adesso funziona, cerca `locations`

            // Altri campi
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price_per_night', 8, 2);
            $table->integer('num_rooms');
            $table->integer('num_bathrooms');
            $table->integer('square_meters');
            $table->integer('max_guests');
            $table->json('amenities'); // lista servizi in formato JSON
            $table->string('main_image_path');
            $table->json('additional_image_paths');
            $table->date('availability_start_date');
            $table->date('availability_end_date');
            $table->boolean('is_active');
            $table->timestamps(); // Questo sostituisce created_at e updated_at manuali
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

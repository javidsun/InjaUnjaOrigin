<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * title: t("HouseReservation"),
     * date: "2025-01-01",
     * icon: "mdi-home",
     * color: "blue",
     * image: "/ads/house.svg",
     * description: "رزرو خانه برای تاریخ 2025-01-01"
     */
    public function up(): void
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation');
    }
};

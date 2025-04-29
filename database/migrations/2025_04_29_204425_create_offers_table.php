<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * school: 'Polino',
     * job: 'Developer',
     * hobbies: 'Reading',
     * traits: 'Creative',
     * birthYear: '1990',
     * languages: 'English, Persian',
     * location: 'Tehran',
     * more: 'فارغ التحصیل رشته معماری و بازاریابی دیجیتال. علاقه مند به سفر و تجربه کردن و آشنا شدن با فرهنگ های جدید. آشنا شدن با
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};

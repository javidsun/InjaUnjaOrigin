<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
        Schema::create('friends_relationship', function (Blueprint $table) {
            $table->ulid('user_id');
            $table->ulid('friend_id');
            $table->timestamps();

            // Chiave primaria composta
            $table->primary(['user_id', 'friend_id']);

            // Chiavi esterne
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('friend_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friends_relationship');
    }
};

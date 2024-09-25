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
        Schema::create('guild_player', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Guild::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Player::class)->constrained()->onDelete('cascade');
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_owner')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guild_player');
    }
};

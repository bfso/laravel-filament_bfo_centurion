<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_quest', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_started')->default(true);
            $table->boolean('is_successful')->nullable()->default(null);
            $table->boolean('is_failed')->nullable()->default(null);
            $table->foreignId('player_id')->constrained();
            $table->foreignId('quest_id')->constrained();
            $table->timestamps();
            $table->unique([
                'player_id',
                'quest_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_quest');
    }
};

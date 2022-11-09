<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('rare')->default(false);
            $table->boolean('legendary')->default(false);
            $table->boolean('craftable')->default(false);
            $table->boolean('moveable')->default(false);
            $table->boolean('buildable')->default(false);
            $table->boolean('takeable')->default(false);
            $table->boolean('eatable')->default(false);
            $table->boolean('claimable')->default(false);
            $table->boolean('interactable')->default(false);
            $table->boolean('equippable')->default(false);
            $table->boolean('is_seeded')->default(false);
            $table->string('image_path')->nullable()->default(null);
            $table->unsignedInteger('requires_level_to_research')->default(0);
            $table->unsignedInteger('requires_level_to_craft')->default(0);
            $table->unsignedInteger('claim_resistance')->default(0);
            $table->unsignedInteger('restores_health_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}

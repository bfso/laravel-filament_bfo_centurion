<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventories', function(Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->integer('slots');
            $table->boolean('equippable')->default(true);
            $table->foreignId('player_id')->constrained();
            $table->foreignId('map_field_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('inventories');
    }
}

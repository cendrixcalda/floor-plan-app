<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFloorPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('floor_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tracking_id')->required();
            $table->string('living_one')->nullable();
            $table->string('living_two')->nullable();
            $table->string('dining')->nullable();
            $table->string('kitchen_with_nook')->nullable();
            $table->string('kitchen_without_nook')->nullable();
            $table->string('scullery/WIP')->nullable();
            $table->string('bathroom_one')->nullable();
            $table->string('WC')->nullable();
            $table->string('bed_one')->nullable();
            $table->string('bed_two')->nullable();
            $table->string('bed_three')->nullable();
            $table->string('entry')->nullable();
            $table->string('garage')->nullable();
            $table->string('laundry')->nullable();
            $table->string('ensuite')->nullable();
            $table->string('WIR')->nullable();
            $table->string('storage_one')->nullable();
            $table->string('storage_two')->nullable();
            $table->string('stairs_one')->nullable();
            $table->string('study_nook')->nullable();
            $table->string('study/Office')->nullable();
            $table->string('gameroom')->nullable();
            $table->string('hallway_one')->nullable();
            $table->string('hallway_two')->nullable();
            $table->string('utility')->nullable();

            $table->string('bathroom_two')->nullable();
            $table->string('bathroom_three')->nullable();
            $table->string('bathroom_four')->nullable();
            $table->string('bathroom_five')->nullable();
            $table->string('WC_two')->nullable();
            $table->string('deck')->nullable();
            $table->string('bedroom_four')->nullable();
            $table->string('bedroom_five')->nullable();
            $table->string('WIR_two')->nullable();
            $table->string('stairs_two')->nullable();
            $table->string('stairs_three')->nullable();
            $table->string('living_three')->nullable();
            $table->string('kitchen_two')->nullable();
            $table->string('hallway_three')->nullable();
            $table->string('hallway_four')->nullable();
            $table->string('hallway_five')->nullable();
            $table->string('storage_three')->nullable();
            $table->string('ensuite_two')->nullable();

            $table->string('floor_level')->nullable();
            $table->string('number_of_levels')->nullable();
            $table->string('area')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();

            $table->string('bedroom_per_level')->nullable();
            $table->string('living_per_level')->nullable();
            $table->string('bathroom_per_level')->nullable();
            $table->string('carport_per_level')->nullable();

            $table->string('bedroom_per_building')->nullable();
            $table->string('living_per_building')->nullable();
            $table->string('bathroom_per_building')->nullable();
            $table->string('carport_per_building')->nullable();

            $table->string('shape')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('floor_plans');
    }
}

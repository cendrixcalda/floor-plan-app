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
            $table->string('living_1')->nullable();
            $table->string('living_2')->nullable();
            $table->string('dining')->nullable();
            $table->string('kitchen_with_nook')->nullable();
            $table->string('kitchen_without_nook')->nullable();
            $table->string('scullery/WIP')->nullable();
            $table->string('bathroom_1')->nullable();
            $table->string('WC')->nullable();
            $table->string('bed_1')->nullable();
            $table->string('bed_2')->nullable();
            $table->string('bed_3')->nullable();
            $table->string('guest_with_ensuite')->nullable();
            $table->string('entry')->nullable();
            $table->string('garage')->nullable();
            $table->string('laundry')->nullable();
            $table->string('ensuite')->nullable();
            $table->string('WIR')->nullable();
            $table->string('storage_1')->nullable();
            $table->string('storage_2')->nullable();
            $table->string('stairs_1')->nullable();
            $table->string('study_nook')->nullable();
            $table->string('study_room')->nullable();
            $table->string('study/Office_nook')->nullable();
            $table->string('gameroom')->nullable();
            $table->string('hallway_1')->nullable();
            $table->string('hallway_2')->nullable();
            $table->string('utility')->nullable();
            $table->string('fire_place')->nullable();

            $table->string('bathroom_2')->nullable();
            $table->string('bathroom_3')->nullable();
            $table->string('bathroom_4')->nullable();
            $table->string('bathroom_5')->nullable();
            $table->string('WC_2')->nullable();
            $table->string('deck_1')->nullable();
            $table->string('deck_2')->nullable();
            $table->string('bedroom_4')->nullable();
            $table->string('bedroom_5')->nullable();
            $table->string('WIR_2')->nullable();
            $table->string('WIR_3')->nullable();
            $table->string('WIR_4')->nullable();
            $table->string('stairs_2')->nullable();
            $table->string('stairs_3')->nullable();
            $table->string('living_3')->nullable();
            $table->string('kitchen_2')->nullable();
            $table->string('hallway_3')->nullable();
            $table->string('hallway_4')->nullable();
            $table->string('hallway_5')->nullable();
            $table->string('ensuite_2')->nullable();
            $table->string('storage_3')->nullable();
            $table->string('storage_4')->nullable();
            $table->string('pool')->nullable();
            $table->string('spa')->nullable();
            $table->string('courtyard')->nullable();

            $table->string('floor_level')->nullable();
            $table->decimal('number_of_levels', 8, 2)->default(0.00);
            $table->decimal('area', 8, 2)->default(0.00);
            $table->decimal('length', 8, 2)->default(0.00);
            $table->decimal('width', 8, 2)->default(0.00);

            $table->decimal('bedroom_per_level', 8, 2)->default(0.00);
            $table->decimal('living_per_level', 8, 2)->default(0.00);
            $table->decimal('bathroom_per_level', 8, 2)->default(0.00);
            $table->decimal('carport_per_level', 8, 2)->default(0.00);

            $table->decimal('bedroom_per_building', 8, 2)->default(0.00);
            $table->decimal('living_per_building', 8, 2)->default(0.00);
            $table->decimal('bathroom_per_building', 8, 2)->default(0.00);
            $table->decimal('carport_per_building', 8, 2)->default(0.00);

            $table->string('shape')->nullable();
            $table->string('remarks')->nullable();
            $table->string('house_name')->nullable();
            $table->string('brand')->nullable();
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

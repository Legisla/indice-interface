<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importations_congresspeople_indicators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_indicator_id');
            $table->unsignedBigInteger('fk_congressperson_id');
            $table->unsignedBigInteger('fk_importation_id');
            $table->integer('number_of_classes')->unsigned()->nullable();
            $table->decimal('value_between_classes',20,2,true)->nullable();
            $table->decimal('indicator_value',20,2,true)->nullable();
            $table->boolean('outlier')->nullable();
            $table->integer('indicator_value_class')->unsigned()->nullable();
            $table->float('adjustment_factor_classes_to_10')->unsigned()->nullable();
            $table->float('indicator_class_adjusted_to_10')->unsigned()->nullable();
            $table->float('indicator_class_adjusted_to_10_formated')->unsigned()->nullable();
            $table->float('indicator_score')->unsigned()->nullable();
            $table->foreign('fk_indicator_id', 'imp_con_ind_fk_ind_fgn')->references('id')->on('indicators');
            $table->foreign('fk_congressperson_id', 'im_con_ind_fk_cong_fgn')->references('id')->on('congresspeople');
            $table->foreign('fk_importation_id', 'im_con_ind_fk_imp_fgn')->references('id')->on('importations');
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
        Schema::dropIfExists('importations_congresspeople_indicators');
    }
};

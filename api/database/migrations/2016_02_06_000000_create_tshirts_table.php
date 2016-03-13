<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTshirtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tshirts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('x');
            $table->integer('y');
            $table->integer('width');
            $table->integer('height');
        });
        DB::statement("ALTER TABLE tshirts ADD thumbnail MEDIUMBLOB");
        DB::statement("ALTER TABLE tshirts ADD user_image_data MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tshirts');
    }
}
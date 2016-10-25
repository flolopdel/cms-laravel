<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTypesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
        
        $dateTime = new DateTime();
        $date = $dateTime->format('Y-m-d H:i:s');
        
        DB::table('product_types')->insert(array('name' => 'Capilar', 'created_at' => $date));
        DB::table('product_types')->insert(array('name' => 'Corporal', 'created_at' => $date));
        DB::table('product_types')->insert(array('name' => 'Dental', 'created_at' => $date));

        Schema::table('products', function($table)
        {
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('product_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_types');
        
        //Remove type_id column
        Schema::table('products', function ($table) {
            $table->dropColumn(['type_id']);
        });
    }
}

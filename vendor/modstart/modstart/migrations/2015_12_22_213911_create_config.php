<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfig extends Migration
{
    
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('key', 100)->nullable()->comment('');
            $table->text('value')->nullable()->comment('');

            $table->index('key');
        });
    }

    
    public function down()
    {

    }
}

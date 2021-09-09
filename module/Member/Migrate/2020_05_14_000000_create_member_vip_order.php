<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberVipOrder extends Migration
{
    
    public function up()
    {
        Schema::create('member_vip_order', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            $table->integer('memberUserId')->nullable()->comment('排序');
            $table->integer('vipId')->nullable()->comment('');
            $table->decimal('payFee', 20, 2)->nullable()->comment('');

            
            $table->tinyInteger('status')->nullable()->comment('默认');

            $table->date('expire')->nullable()->comment('');
            $table->string('type', 20)->nullable()->comment('');

        });
    }

    
    public function down()
    {

    }
}

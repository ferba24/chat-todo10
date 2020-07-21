<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class XenUsers extends Migration{
    public function up(){
        Schema::create('xenusers', function (Blueprint $table) {
            $table->string('user_id')->unique();
            $table->text('json');
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('xenusers');
    }
}

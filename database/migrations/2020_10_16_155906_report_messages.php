<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReportMessages extends Migration{
    public function up(){
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('message_id');
            $table->text('reason');
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('reports');
    }
}

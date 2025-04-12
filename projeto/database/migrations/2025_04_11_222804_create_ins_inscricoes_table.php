<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ins_inscricoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cur_id');
            $table->unsignedBigInteger('usu_id');
            $table->string('ins_status')->default('pendente');
            $table->timestamp('ins_data_inscricao')->useCurrent();
            $table->decimal('valor_pago', 10, 2)->default(0.00);
            $table->timestamps();
            
            $table->foreign('cur_id')->references('cur_id')->on('cur_curso')->onDelete('cascade');
            $table->foreign('usu_id')->references('usu_id')->on('usu_usuario')->onDelete('cascade');
            
            $table->unique(['usu_id', 'cur_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ins_inscricoes');
    }
};

<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cur_curso', function (Blueprint $table) {
            $table->id('cur_id');
            $table->string('cur_nome');
            $table->text('cur_descricao');
            $table->decimal('cur_valor', 10, 2);
            $table->datetime('cur_data_inscricoes_inicio');
            $table->datetime('cur_data_inscricoes_fim');
            $table->integer('cur_vagas');
            $table->boolean('cur_ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cur_curso');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usu_usuario', function (Blueprint $table) {
            $table->id('usu_id');
            $table->string('usu_email')->unique();
            $table->string('usu_senha');
            $table->boolean('usu_is_adm')->default(false);
            $table->boolean('usu_ativo')->default(true);
            $table->string('usu_cpf')->nullable();
            $table->text('usu_endereco')->nullable();
            $table->string('usu_empresa')->nullable();
            $table->string('usu_telefone')->nullable();
            $table->string('usu_celular')->nullable();
            $table->string('usu_tipo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usu_usuario');
    }
};

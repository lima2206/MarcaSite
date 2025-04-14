<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cur_nome' => $this->faker->sentence(3),
            'cur_descricao' => $this->faker->paragraph(),
            'cur_valor' => $this->faker->randomFloat(2, 100, 2000),
            'cur_data_inscricoes_inicio' => now()->subDays(10),
            'cur_data_inscricoes_fim' => now()->addDays(10),
            'cur_vagas' => $this->faker->numberBetween(10, 100),
            'cur_ativo' => $this->faker->boolean(90),
            'cur_imagem' => 'https://via.placeholder.com/150',
            'cur_material' => 'https://example.com/material.pdf',
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Curso;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class InscricaoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cur_id' => Curso::inRandomOrder()->first()->cur_id ?? Curso::factory(),
            'usu_id' => Usuario::inRandomOrder()->first()->usu_id ?? Usuario::factory(),
            'ins_status' => $this->faker->randomElement(['Confirmado', 'Pendente', 'Cancelado']),
            'ins_data_inscricao' => $this->faker->dateTimeBetween('-10 days', 'now'),
            'valor_pago' => $this->faker->randomFloat(2, 50, 1500),
        ];
    }
}

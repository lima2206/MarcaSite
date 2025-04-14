<?php

namespace Database\Factories;

use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'usu_email' => $this->faker->unique()->safeEmail(),
            'usu_senha' => Hash::make('password'),
            'usu_is_adm' => $this->faker->boolean(10),
            'usu_ativo' => true,
            'usu_nome' => $this->faker->name(),
            'usu_cpf' => $this->faker->unique()->numerify('###.###.###-##'),
            'usu_endereco' => $this->faker->address(),
            'usu_empresa' => $this->faker->company(),
            'usu_telefone' => $this->faker->phoneNumber(),
            'usu_celular' => $this->faker->phoneNumber(), 
            'usu_tipo' => $this->faker->randomElement(['Estudante', 'Professor', 'Profissional']),
        ];
    }
}

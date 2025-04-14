<?php

namespace Database\Seeders;

use App\Models\Inscricao;
use App\Models\Usuario;
use App\Models\Curso;
use Illuminate\Database\Seeder;

class InscricaoSeeder extends Seeder
{
    public function run()
    {
        $usuarios = Usuario::all(); // Fetch all users
        $cursos = Curso::all(); // Fetch all courses

        foreach ($usuarios as $usuario) {
            foreach ($cursos as $curso) {
                // Prevent duplicate enrollment by checking if it exists, then creating or updating
                Inscricao::updateOrCreate(
                    [
                        'usu_id' => $usuario->usu_id,
                        'cur_id' => $curso->cur_id,
                    ],
                    [
                        'ins_status' => 'Pendente',
                        'ins_data_inscricao' => now(),
                        'valor_pago' => $this->faker->randomFloat(2, 50, 500), // example value
                    ]
                );
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Curso;
use App\Models\Inscricao;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::factory(50)->create();
        Curso::factory(10)->create();
        $this->call([
            InscricaoSeeder::class // Make sure to call the InscricaoSeede
        ]);



    }
}

<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjetoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projetos')->insert([
            [
                'nome' => 'Projeto Alpha',
                'descricao' => 'Descrição do Projeto Alpha',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Projeto Beta',
                'descricao' => 'Descrição do Projeto Beta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Projeto Gamma',
                'descricao' => 'Descrição do Projeto Gamma',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

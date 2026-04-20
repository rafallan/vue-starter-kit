<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status')->insert([
            [
                'nome' => 'Pendente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Em Progresso',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Concluído',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

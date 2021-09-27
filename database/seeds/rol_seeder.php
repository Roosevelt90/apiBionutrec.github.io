<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class rol_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rol')->insert(
            [
                'id' => 1,
                'name' => 'root'
            ],
            [
                'id' => 2,
                'name' => 'Administrador'
            ],
            [
                'id' => 3,
                'name' => 'Asesor'
            ]
        );
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class type_identification_seeder extends Seeder
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
                'name' => 'Cedula de ciudadanía'
            ],
            [
                'id' => 2,
                'name' => 'Cedula de extranjería'
            ],
            [
                'id' => 3,
                'name' => 'Pasaporte'
            ]
        );
    }
}

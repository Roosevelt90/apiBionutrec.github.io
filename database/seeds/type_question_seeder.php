<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class type_question_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_question')->insert(
            [
                'id' => 1,
                'name' => 'Texto'
            ],
            [
                'id' => 2,
                'name' => 'Númerico'
            ],
            [
                'id' => 3,
                'name' => 'Correo electrónico'
            ],
            [
                'id' => 4,
                'name' => 'Selección unica'
            ],
            [
                'id' => 5,
                'name' => 'Selección multiple'
            ]
        );
    }
}

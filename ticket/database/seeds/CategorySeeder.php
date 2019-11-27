<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends  Seeder
{
    public function run()
    {
        DB::table('categories')
            ->insert([
                'name' => 'problema tecnico',
                'description' => 'Si es un problema técnico'
            ]);

        DB::table('categories')
            ->insert([
                'name' => 'herramienta cloud',
                'description' => 'Si es un problema con la herramienta Cloud'
            ]);
    }

}

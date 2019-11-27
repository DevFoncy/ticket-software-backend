<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends  Seeder
{

    public function run()
    {
        DB::table('tickets')
            ->insert([
                'user_id' => 1,
                'category_id' => 1,
                'title' => 'Este es un ejemplo de ticket',
                'priority' => 'Alta',
            ]);

    }
}

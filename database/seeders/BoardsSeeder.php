<?php

namespace Database\Seeders;

use App\Models\Boards;
use Illuminate\Database\Seeder;

class BoardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Boards::create([
            'board_number' => 'board-1',
            'amount' => '100',
        ]);
        Boards::create([
            'board_number' => 'board-2',
            'amount' => '400',
        ]);
        Boards::create([
            'board_number' => 'board-3',
            'amount' => '1000',
        ]);
        Boards::create([
            'board_number' => 'board-4',
            'amount' => '2000',
        ]);
    }
}

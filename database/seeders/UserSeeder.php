<?php

namespace Database\Seeders;

use App\Models\Boards;
use App\Models\User;
use App\Models\UserBoards;
use App\Models\UserProfileChangedLogs;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $board100 = Boards::create([
            'board_number' => 'board-1',
            'amount' => '100',
        ]);
        $board400 = Boards::create([
            'board_number' => 'board-2',
            'amount' => '400',
        ]);
        $board1000 =Boards::create([
            'board_number' => 'board-3',
            'amount' => '1000',
        ]);
        $board2000 =Boards::create([
            'board_number' => 'board-4',
            'amount' => '2000',
        ]);

        $admin = User::create([
            'invited_by' => '0',
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@uib.com',
            'phone' => '321654987',
            'role' => 'admin',
            'password' => Hash::make('admin@123'),
        ]);

        UserBoards::create([
            'user_id' => $admin->id,
            'board_id' => $board100->id,
            'parent_id' => null,
            'user_board_roles' => 'grad',
            'position' => null
        ]);

        UserProfileChangedLogs::create([
            'user_id' => $admin->id,
            'key' => 'username',
            'value' => $admin->username,
            'old_value' => 0,
            'message' => 'New Account Created',
        ]);

        $user1 = User::create([
            'invited_by' => '0',
            'username' => 'user1',
            'first_name' => 'User',
            'last_name' => 'One',
            'email' => 'user1@mailinator.com',
            'phone' => '321654987',
            'password' => Hash::make('Pa$$w0rd!'),
        ]);

        UserBoards::create([
            'user_id' => $user1->id,
            'board_id' => $board100->id,
            'parent_id' => $admin->id,
            'user_board_roles' => 'pregrad',
            'position' => 'left'
        ]);

        $user2 = User::create([
            'invited_by' => '0',
            'username' => 'user2',
            'first_name' => 'User',
            'last_name' => 'Two',
            'email' => 'user2@mailinator.com',
            'phone' => '321654987',
            'password' => Hash::make('Pa$$w0rd!'),
        ]);

        UserBoards::create([
            'user_id' => $user2->id,
            'board_id' => $board100->id,
            'parent_id' => $admin->id,
            'user_board_roles' => 'pregrad',
            'position' => 'right'
        ]);

        $user3 = User::create([
            'invited_by' => '0',
            'username' => 'user3',
            'first_name' => 'User',
            'last_name' => 'Three',
            'email' => 'user3@mailinator.com',
            'phone' => '321654987',
            'password' => Hash::make('Pa$$w0rd!'),
        ]);

        UserBoards::create([
            'user_id' => $user3->id,
            'board_id' => $board100->id,
            'parent_id' => $user1->id,
            'user_board_roles' => 'undergrad',
            'position' => 'left'
        ]);

        $user4 = User::create([
            'invited_by' => '0',
            'username' => 'user4',
            'first_name' => 'User',
            'last_name' => 'Four',
            'email' => 'user4@mailinator.com',
            'phone' => '321654987',
            'password' => Hash::make('Pa$$w0rd!'),
        ]);

        UserBoards::create([
            'user_id' => $user4->id,
            'board_id' => $board100->id,
            'parent_id' => $user1->id,
            'user_board_roles' => 'undergrad',
            'position' => 'right'
        ]);

        $user5 = User::create([
            'invited_by' => '0',
            'username' => 'user5',
            'first_name' => 'User',
            'last_name' => 'Five',
            'email' => 'user5@mailinator.com',
            'phone' => '321654987',
            'password' => Hash::make('Pa$$w0rd!'),
        ]);

        UserBoards::create([
            'user_id' => $user5->id,
            'board_id' => $board100->id,
            'parent_id' => $user2->id,
            'user_board_roles' => 'undergrad',
            'position' => 'left'
        ]);

        $user6 = User::create([
            'invited_by' => '0',
            'username' => 'user6',
            'first_name' => 'User',
            'last_name' => 'Six',
            'email' => 'user6@mailinator.com',
            'phone' => '321654987',
            'password' => Hash::make('Pa$$w0rd!'),
        ]);

        UserBoards::create([
            'user_id' => $user6->id,
            'board_id' => $board100->id,
            'parent_id' => $user2->id,
            'user_board_roles' => 'undergrad',
            'position' => 'right'
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Boards;
use App\Models\GiftLogs;
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
        User::truncate();

        $board100 = Boards::create([
            'board_number' => '123455',
            'amount' => '100',
            'previous_board_number' => '123454',
        ]);

        $board400 = Boards::create([
            'board_number' => '1234567',
            'amount' => '400',
            //'previous_board_number' => '1234566',
            'previous_board_number' => '123455',
        ]);

//        $board1000 = Boards::create([
//            'board_number' => '1234578',
//            'amount' => '1000',
//            'previous_board_number' => '1234577',
//        ]);
//
//        $board2000 = Boards::create([
//            'board_number' => '1234580',
//            'amount' => '2000',
//        ]);

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

        $pringles2025 = User::create([
            'invited_by' => $admin->id,
            'username' => 'MyBlessing2',
            'first_name' => 'Elliott',
            'last_name' => 'Nichols',
            'email' => 'elliottnichols59@gmail.com',
            'phone' => '619-779-7928',
            'password' => Hash::make('user@123'),
        ]);

        UserBoards::create([
            'user_id' => $pringles2025->id,
            'board_id' => $board100->id,
            'user_board_roles' => 'grad',
            'position' => 'left',
        ]);

        UserProfileChangedLogs::create([
            'user_id' => $pringles2025->id,
            'key' => 'username',
            'value' => $pringles2025->username,
            'old_value' => 0,
            'message' => 'New Account Created',
        ]);

        UserProfileChangedLogs::create([
            'user_id' => $pringles2025->id,
            'key' => 'password',
            'value' => 'user@123',
            'old_value' => 0,
            'message' => 'New Account Created',
        ]);

        $heart2hand = User::create([
            'invited_by' => $admin->id,
            'username' => '4Pringles2025',
            'first_name' => 'Elliott',
            'last_name' => 'Nichols',
            'email' => 'elliottnichols59@gmail.com',
            'phone' => '619-779-7928',
            'password' => Hash::make('user@123'),
        ]);

        UserBoards::create([
            'user_id' => $heart2hand->id,
            'board_id' => $board100->id,
            'parent_id' => $pringles2025->id,
            'user_board_roles' => 'pregrad',
            'position' => 'left',
        ]);

        UserProfileChangedLogs::create([
            'user_id' => $heart2hand->id,
            'key' => 'username',
            'value' => $heart2hand->username,
            'old_value' => 0,
            'message' => 'New Account Created',
        ]);

        UserProfileChangedLogs::create([
            'user_id' => $heart2hand->id,
            'key' => 'password',
            'value' => 'user@123',
            'old_value' => 0,
            'message' => 'New Account Created',
        ]);

//        $giftgiver = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'giftgiver',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $giftgiver->id,
//            'board_id' => $board100->id,
//            'parent_id' => $pringles2025->id,
//            'user_board_roles' => 'pregrad',
//            'position' => 'right',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $giftgiver->id,
//            'key' => 'username',
//            'value' => $giftgiver->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $giftgiver->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $saabkptr = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'saabkptr',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $saabkptr->id,
//            'board_id' => $board100->id,
//            'parent_id' => $heart2hand->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $saabkptr->id,
//            'key' => 'username',
//            'value' => $saabkptr->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $saabkptr->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $mar1000 = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'mar1000',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $mar1000->id,
//            'board_id' => $board100->id,
//            'parent_id' => $heart2hand->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'right',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $mar1000->id,
//            'key' => 'username',
//            'value' => $mar1000->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $mar1000->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $rdkh1 = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'rdkh1',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $rdkh1->id,
//            'board_id' => $board100->id,
//            'parent_id' => $giftgiver->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $rdkh1->id,
//            'key' => 'username',
//            'value' => $rdkh1->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $rdkh1->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $coachmakayla1 = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'coachmakayla1',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $coachmakayla1->id,
//            'board_id' => $board100->id,
//            'parent_id' => $giftgiver->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'right',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $coachmakayla1->id,
//            'key' => 'username',
//            'value' => $coachmakayla1->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $coachmakayla1->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $maehelen = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'maehelen',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $maehelen->id,
//            'board_id' => $board400->id,
//            'parent_id' => null,
//            'user_board_roles' => 'grad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $maehelen->id,
//            'key' => 'username',
//            'value' => $maehelen->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $maehelen->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $synergy3 = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'synergy3',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $synergy3->id,
//            'board_id' => $board400->id,
//            'parent_id' => $maehelen->id,
//            'user_board_roles' => 'pregrad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $synergy3->id,
//            'key' => 'username',
//            'value' => $synergy3->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $synergy3->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $daddysgirl = User::create([
//            'invited_by' => $admin->id,
//            'username' => '1DaddysGirl',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $daddysgirl->id,
//            'board_id' => $board400->id,
//            'parent_id' => $maehelen->id,
//            'user_board_roles' => 'pregrad',
//            'position' => 'right',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $daddysgirl->id,
//            'key' => 'username',
//            'value' => $daddysgirl->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $daddysgirl->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $pringles2020 = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'Pringles2020',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $pringles2020->id,
//            'board_id' => $board400->id,
//            'parent_id' => $synergy3->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $pringles2020->id,
//            'key' => 'username',
//            'value' => $pringles2020->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $pringles2020->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $team2K = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'Team2K',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $team2K->id,
//            'board_id' => $board400->id,
//            'parent_id' => $synergy3->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'right',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $team2K->id,
//            'key' => 'username',
//            'value' => $team2K->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $team2K->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $generous1 = User::create([
//            'invited_by' => $admin->id,
//            'username' => '4Generous1',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $generous1->id,
//            'board_id' => $board400->id,
//            'parent_id' => $daddysgirl->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $generous1->id,
//            'key' => 'username',
//            'value' => $generous1->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $generous1->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserBoards::create([
//            'user_id' => $pringles2025->id,
//            'board_id' => $board400->id,
//            'parent_id' => $daddysgirl->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'right',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $pringles2025->id,
//            'key' => 'username',
//            'value' => $pringles2025->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $pringles2025->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $nzinga = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'Nzinga',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $nzinga->id,
//            'board_id' => $board1000->id,
//            'parent_id' => null,
//            'user_board_roles' => 'grad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $nzinga->id,
//            'key' => 'username',
//            'value' => $nzinga->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $nzinga->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $LoyalT1 = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'LoyalT1',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $LoyalT1->id,
//            'board_id' => $board1000->id,
//            'parent_id' => $nzinga->id,
//            'user_board_roles' => 'pregrad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $LoyalT1->id,
//            'key' => 'username',
//            'value' => $LoyalT1->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $LoyalT1->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $ghettoeinstein1 = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'ghettoeinstein1',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $ghettoeinstein1->id,
//            'board_id' => $board1000->id,
//            'parent_id' => $nzinga->id,
//            'user_board_roles' => 'pregrad',
//            'position' => 'right',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $ghettoeinstein1->id,
//            'key' => 'username',
//            'value' => $ghettoeinstein1->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $ghettoeinstein1->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $Zamiyrah = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'Zamiyrah',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $Zamiyrah->id,
//            'board_id' => $board1000->id,
//            'parent_id' => $LoyalT1->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $Zamiyrah->id,
//            'key' => 'username',
//            'value' => $Zamiyrah->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $Zamiyrah->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//
//        UserBoards::create([
//            'user_id' => $maehelen->id,
//            'board_id' => $board1000->id,
//            'parent_id' => $LoyalT1->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'right',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $maehelen->id,
//            'key' => 'username',
//            'value' => $maehelen->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $maehelen->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $EyeAmLove1 = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'EyeAmLove1',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $EyeAmLove1->id,
//            'board_id' => $board1000->id,
//            'parent_id' => $ghettoeinstein1->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $EyeAmLove1->id,
//            'key' => 'username',
//            'value' => $EyeAmLove1->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $EyeAmLove1->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserBoards::create([
//            'user_id' => $daddysgirl->id,
//            'board_id' => $board1000->id,
//            'parent_id' => $ghettoeinstein1->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'right',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $daddysgirl->id,
//            'key' => 'username',
//            'value' => $daddysgirl->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $daddysgirl->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserBoards::create([
//            'user_id' => $LoyalT1->id,
//            'board_id' => $board2000->id,
//            'parent_id' => null,
//            'user_board_roles' => 'grad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $LoyalT1->id,
//            'key' => 'username',
//            'value' => $LoyalT1->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $LoyalT1->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserBoards::create([
//            'user_id' => $Zamiyrah->id,
//            'board_id' => $board2000->id,
//            'parent_id' => $LoyalT1->id,
//            'user_board_roles' => 'pregrad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $Zamiyrah->id,
//            'key' => 'username',
//            'value' => $Zamiyrah->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $Zamiyrah->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserBoards::create([
//            'user_id' => $maehelen->id,
//            'board_id' => $board2000->id,
//            'parent_id' => $LoyalT1->id,
//            'user_board_roles' => 'pregrad',
//            'position' => 'right',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $maehelen->id,
//            'key' => 'username',
//            'value' => $maehelen->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $maehelen->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserBoards::create([
//            'user_id' => $pringles2025->id,
//            'board_id' => $board2000->id,
//            'parent_id' => $Zamiyrah->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $pringles2025->id,
//            'key' => 'username',
//            'value' => $pringles2025->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $pringles2025->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $hearts = User::create([
//            'invited_by' => $admin->id,
//            'username' => '3Hearts',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $hearts->id,
//            'board_id' => $board2000->id,
//            'parent_id' => $Zamiyrah->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'right',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $hearts->id,
//            'key' => 'username',
//            'value' => $hearts->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $hearts->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $DaisyMary = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'DaisyMary',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $DaisyMary->id,
//            'board_id' => $board2000->id,
//            'parent_id' => $maehelen->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'left',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $DaisyMary->id,
//            'key' => 'username',
//            'value' => $DaisyMary->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $DaisyMary->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        $DJs2021 = User::create([
//            'invited_by' => $admin->id,
//            'username' => 'DJs2021',
//            'first_name' => 'Elliott',
//            'last_name' => 'Nichols',
//            'email' => 'elliottnichols59@gmail.com',
//            'phone' => '619-779-7928',
//            'password' => Hash::make('user@123'),
//        ]);
//
//        UserBoards::create([
//            'user_id' => $DJs2021->id,
//            'board_id' => $board2000->id,
//            'parent_id' => $maehelen->id,
//            'user_board_roles' => 'undergrad',
//            'position' => 'right',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $DJs2021->id,
//            'key' => 'username',
//            'value' => $DJs2021->username,
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);
//
//        UserProfileChangedLogs::create([
//            'user_id' => $DJs2021->id,
//            'key' => 'password',
//            'value' => 'user@123',
//            'old_value' => 0,
//            'message' => 'New Account Created',
//        ]);


    }
}

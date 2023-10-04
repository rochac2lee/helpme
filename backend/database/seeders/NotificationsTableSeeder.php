<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = User::all();

        foreach ($users as $user) {
            $message = "Olá $user->name, Seja bem vindo ao sistema help.me!";

            $notification = new Notification();
            $notification->user_id = $user->id;
            $notification->client_id = $user->client_id ?? NULL;
            $notification->created_by = 0;
            $notification->message = (string) $message;
            $notification->read = false;
            $notification->save();
        }

    }
}

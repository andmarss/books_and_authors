<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Загрузка пользователей...');
        User::query()->truncate();

        User::factory()->count(env('USER_SEEDER_AMOUNT', 10))->create();
        $this->command->info('Пользователи загружены');
    }
}

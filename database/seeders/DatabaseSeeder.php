<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->call('migrate:fresh');
        $this->command->warn('База данных очищена');

        $this->call([
            UserTableSeeder::class,
            BookTableSeeder::class,
        ]);
    }
}

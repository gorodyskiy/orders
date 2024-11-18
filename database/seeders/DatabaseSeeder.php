<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Status::create([
            'slug' => 'new',
            'name' => 'Новый',
        ]);
        Status::create([
            'slug' => 'inprogress',
            'name' => 'В обработке',
        ]);
        Status::create([
            'slug' => 'sent',
            'name' => 'Отправлен',
        ]);
        Status::create([
            'slug' => 'delivered',
            'name' => 'Доставлен',
        ]);
    }
}

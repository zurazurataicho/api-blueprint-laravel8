<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ApplicationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Application::truncate();
        \App\Models\Application::create([
            'name' => 'アプリ 太郎',
            'email' => 'application@test.jp',
            'email_verified_at' => now(),
            'url' => 'https://application.example.jp/taro.php'
        ]);
        \App\Models\Application::factory(9)->create();
    }
}

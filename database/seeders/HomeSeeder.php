<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Home;

class HomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Home::create([
            'intro_id' => "Saya {alias} a.k.a {realname}",
            'intro_en' => "I'm {alias} a.k.a {realname}",
            'myself_id' => "Ini adalah {alias} {'|'} {realname}, Newbie Web Developer, Frontend Developer, and Backend Developer yang tinggal di Indonesia, fans aespa dengan bias {bias}.",
            'myself_en' => "This is {alias} {'|'} {realname}, Newbie Web Developer, Frontend Developer, and Backend Developer located Indonesia, aespa fans with {bias} as bias.",            
        ]);
    }
}

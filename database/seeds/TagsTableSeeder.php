<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    public function run()
    {
        $tags = ["Рад", "Губ", "Лоб", "Скул", "Био", "СР", "Подб", "Подм"];

        foreach ($tags as $city) {
            \App\Models\Tag::create(['name' => $city]);
        }
    }
}

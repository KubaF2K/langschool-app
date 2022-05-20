<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Course::truncate();
        Language::truncate();
        Schema::enableForeignKeyConstraints();
        Language::upsert(
            [
                ['code' => 'EN', 'name' => 'Angielski', 'description' => '', 'img' => 'en.webp'],
                ['code' => 'PL', 'name' => 'Polski', 'description' => '', 'img' => 'pl.webp'],
                ['code' => 'DE', 'name' => 'Niemiecki', 'description' => '', 'img' => 'de.webp'],
                ['code' => 'ES', 'name' => 'Hiszpański', 'description' => '', 'img' => 'es.webp'],
                ['code' => 'FR', 'name' => 'Francuski', 'description' => '', 'img' => 'fr.webp']
            ],
            'code'
        );
    }
}

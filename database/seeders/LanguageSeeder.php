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
                ['code' => 'EN', 'name' => 'Angielski', 'description' => 'Język przydatny wszędzie'],
                ['code' => 'PL', 'name' => 'Polski', 'description' => 'Nasza ojczysta mowa'],
                ['code' => 'DE', 'name' => 'Niemiecki', 'description' => 'Język sąsiadów z zachodu'],
                ['code' => 'ES', 'name' => 'Hiszpański', 'description' => 'Język kraju flamenco'],
                ['code' => 'FR', 'name' => 'Francuski', 'description' => 'Oficjalny język Unii Europejskiej']
            ],
            'code'
        );
    }
}

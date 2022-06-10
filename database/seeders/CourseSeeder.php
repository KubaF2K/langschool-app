<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CourseSeeder extends Seeder
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
        Schema::enableForeignKeyConstraints();
        Course::upsert(
            [
                [
                    'name' => 'Angielski podstawowy',
                    'hours' => 5,
                    'description' => 'Poznaj podstawy języka którym można się dogadać prawie wszędzie! Ten kurs uczy angielskiego od podstaw, w prosty sposób nauczysz się słów i zwrotów przydatnych na co dzień.',
                    'price' => 550,
                    'language_id' => 1,
                    'teacher_id' => 2
                ],
                [
                    'name' => 'Angielski zaawansowany',
                    'hours' => 6,
                    'description' => 'Ten kurs jest przeznaczony dla osób które chcą udoskonalić swoją znajomość języka angielskiego. Celem kursu jest kształtowanie umiejętności komunikacji oraz poznanie nowych zwrotów i wyrażeń.',
                    'price' => 800,
                    'language_id' => 1,
                    'teacher_id' => 2
                ],
                [
                    'name' => 'Polski dla obcokrajowców',
                    'hours' => 4,
                    'description' => 'Jeśli potrzebujesz poznać polski lepiej, ten kurs jest dla ciebie. Pomoże ci szybko poznać polski w stopniu komunikatywnym.',
                    'price' => 450,
                    'language_id' => 2,
                    'teacher_id' => 3
                ],
                [
                    'name' => 'Niemiecki podstawowy',
                    'hours' => 5,
                    'description' => 'Poznaj podstawy języka sąsiadów z zachodu. Kurs opracowany jest z myślą o praktycznym zastosowaniu języka.',
                    'price' => 520,
                    'language_id' => 3,
                    'teacher_id' => 4
                ],
                [
                    'name' => 'Niemiecki zaawansowany',
                    'hours' => 6,
                    'description' => 'Kurs niemiecki dla zaawansowanych umożliwia opanowanie prawie 2000 nowych wyrażeń i poznać bliżej gramatykę.',
                    'price' => 780,
                    'language_id' => 3,
                    'teacher_id' => 4
                ],
                [
                    'name' => 'Hiszpański podstawowy',
                    'hours' => 5,
                    'description' => 'Poznaj podstawy hiszpańskiego dzięki naszemu kursowi. W łatwy sposób możesz poznać 2500 słów i opanować podstawową komunikację.',
                    'price' => 500,
                    'language_id' => 4,
                    'teacher_id' => 5
                ],
                [
                    'name' => 'Hiszpański zaawansowany',
                    'hours' => 6,
                    'description' => 'Nasz kurs zaawansowanego hiszpańskiego rozszerza nasz kurs podstawowy o 4000 słów i wyrażeń, plus pozwala na naukę słownictwa używanego na co dzień.',
                    'price' => 750,
                    'language_id' => 4,
                    'teacher_id' => 5
                ],
                [
                    'name' => 'Francuski podstawowy',
                    'hours' => 5,
                    'description' => 'Kurs francuskiego podstawowego pozwala na przyswojenie wymowy i podstawowego słownictwa potrzebnego w życiu codziennym.',
                    'price' => 500,
                    'language_id' => 5,
                    'teacher_id' => 6
                ],
                [
                    'name' => 'Francuski zaawansowany',
                    'hours' => 6,
                    'description' => 'Francuski zaawansowany utrwala materiał poznany w kursie podstawowym oraz uczy 3000 nowych wyrażeń, nastawionych na kulturę i obyczaje.',
                    'price' => 750,
                    'language_id' => 5,
                    'teacher_id' => 6
                ]
            ],
            'name'
        );
    }
}

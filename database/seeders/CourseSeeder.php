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
                    'description' => '',
                    'price' => 550,
                    'language_id' => 1,
                    'teacher_id' => 2
                ],
                [
                    'name' => 'Angielski zaawansowany',
                    'hours' => 6,
                    'description' => '',
                    'price' => 800,
                    'language_id' => 1,
                    'teacher_id' => 2
                ],
                [
                    'name' => 'Polski dla obcokrajowców',
                    'hours' => 4,
                    'description' => '',
                    'price' => 450,
                    'language_id' => 2,
                    'teacher_id' => 3
                ],
                [
                    'name' => 'Niemiecki podstawowy',
                    'hours' => 5,
                    'description' => '',
                    'price' => 520,
                    'language_id' => 3,
                    'teacher_id' => 4
                ],
                [
                    'name' => 'Niemiecki zaawansowany',
                    'hours' => 6,
                    'description' => '',
                    'price' => 780,
                    'language_id' => 3,
                    'teacher_id' => 4
                ],
                [
                    'name' => 'Hiszpański podstawowy',
                    'hours' => 5,
                    'description' => '',
                    'price' => 500,
                    'language_id' => 4,
                    'teacher_id' => 5
                ],
                [
                    'name' => 'Hiszpański zaawansowany',
                    'hours' => 6,
                    'description' => '',
                    'price' => 750,
                    'language_id' => 4,
                    'teacher_id' => 5
                ],
                [
                    'name' => 'Francuski podstawowy',
                    'hours' => 5,
                    'description' => '',
                    'price' => 500,
                    'language_id' => 5,
                    'teacher_id' => 6
                ],
                [
                    'name' => 'Francuski zaawansowany',
                    'hours' => 6,
                    'description' => '',
                    'price' => 750,
                    'language_id' => 5,
                    'teacher_id' => 6
                ]
            ],
            'name'
        );
    }
}

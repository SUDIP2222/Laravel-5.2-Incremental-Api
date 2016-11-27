<?php

use Illuminate\Database\Seeder;
use App\Lesson;
use App\Tag;
use Faker\Factory as Faker;

use Illuminate\Support\Facades\DB;

class LessonsTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $lessonIds = DB::table('lessons')->pluck('id');
        $tagIds = DB::table('tags')->pluck('id');

        foreach (range(1, 30) as $index) {
            DB::table('lesson_tag')->insert([
                'lesson_id' => $faker->randomElement($lessonIds),
                'tag_id' => $faker->randomElement($tagIds),
            ]);

        }
    }
}

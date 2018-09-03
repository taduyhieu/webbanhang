<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeding.
     */
    public function run()
    {
        DB::table('categories')->truncate();

        DB::table('categories')->insert(array(
            array(
                'title' => 'Tin tức',
                'slug' => Str::slug('Tin tức'),
                'lang' => 'vi', ),
            array(
                'title' => 'Giới thiệu',
                'slug' => Str::slug('Giới thiệu'),
                'lang' => 'vi', ), ));
    }
}

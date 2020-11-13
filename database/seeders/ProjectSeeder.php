<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = [
            [
                'title' => $this->faker->name,
                'description' => $this->faker->paragraph,
                'status' => $this->faker->numberBetween(1,2),
                'created'=> now(),
            ]
        ];
        foreach ($projects as $key => $project) {
           DB::table('projects')->insert([
                'title' => $project['title'],
           ]);
        }
    }
}

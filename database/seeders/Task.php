<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class Task extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->delete();
        $projects = Project::all();
        $tasks = [];
        foreach ($projects as $project) {
            $newTeam = array(
                'project_id' => $project->id,
                'name' => fake()->unique()->company(),
                'priority' => rand(1,4)
            );
            array_push($tasks, $newTeam);
        }

        DB::table('tasks')->insert($tasks);
    }
}

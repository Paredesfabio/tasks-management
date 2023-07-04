<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Project extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->delete();

		$divisions = array(
			array('name' => fake()->company(), 'description' => fake()->paragraph()),
			array('name' => fake()->company(), 'description' => fake()->paragraph()),
			array('name' => fake()->company(), 'description' => fake()->paragraph()),
			array('name' => fake()->company(), 'description' => fake()->paragraph()),
			array('name' => fake()->company(), 'description' => fake()->paragraph()),
			array('name' => fake()->company(), 'description' => fake()->paragraph()),
            array('name' => fake()->company(), 'description' => fake()->paragraph()),
            array('name' => fake()->company(), 'description' => fake()->paragraph()),
            array('name' => fake()->company(), 'description' => fake()->paragraph()),
		);

		DB::table('projects')->insert($divisions);
    }
}

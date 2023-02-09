<?php

namespace Database\Seeders;

use App\Models\Exercice;
use Illuminate\Database\Seeder;

class ExerciceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exercices = [
            ['type' => 'E', 'enabled' => 1, 'name' => 'Boomerang', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Control Balance', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'CorkScrew', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Double Leg Kick', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Double Leg Stretch', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Hip twist', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Hundred', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'JackKnife', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Kneeling Side Kick', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'LEG PULL BACK', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'LEG PULL FRONT', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Leg Pulls', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Neck PulL', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'One Leg Circle', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'One Leg Kick', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'One Leg Stretch', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Push up', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Rocker With Open Legs', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Rocking', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Roll Over', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Roll up', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Rolling Back', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Saw', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Scissors e bicycle', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Seal and Crab', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Shoulder brigde', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Side BenD', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Side Kick', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Spine Stretch', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Spine Twist', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'SPINE TWIST MAT PILATES', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Swan DivE', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Swimming', 'description' => ''],
            ['type' => 'E', 'enabled' => 1, 'name' => 'Teaser', 'description' => ''],
            ['type' => 'A', 'enabled' => 1, 'name' => 'Cadillac', 'description' => ''],
            ['type' => 'A', 'enabled' => 1, 'name' => 'Reformer', 'description' => ''],
            ['type' => 'A', 'enabled' => 1, 'name' => 'Chair', 'description' => ''],
            ['type' => 'A', 'enabled' => 1, 'name' => 'Barrel', 'description' => ''],
        ];


        foreach($exercices as $ex) {

            Exercice::create($ex);
        }
    }
}

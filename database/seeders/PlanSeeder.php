<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            ['name' => 'Mensal (1x)', 'value' => '100.00', 'class_per_week' => 1, 'duration' => 1, 'enabled' => rand(1,0)],
            ['name' => 'Mensal (2x)', 'value' => '200.00', 'class_per_week' => 2, 'duration' => 1, 'enabled' => rand(1,0)],
            ['name' => 'Mensal (3x)', 'value' => '300.00', 'class_per_week' => 3, 'duration' => 1, 'enabled' => rand(1,0)],

            ['name' => 'Trimestral (1x)', 'value' => '500.00', 'class_per_week' => 1, 'duration' => 3, 'enabled' => rand(1,0)],
            ['name' => 'Trimestral (2x)', 'value' => '600.00', 'class_per_week' => 2, 'duration' => 3, 'enabled' => rand(1,0)],
            ['name' => 'Trimestral (3x)', 'value' => '700.00', 'class_per_week' => 3, 'duration' => 3, 'enabled' => rand(1,0)],

            ['name' => 'Anual (1x)', 'value' => '900.00',  'class_per_week' => 1, 'duration' => 12, 'enabled' => rand(1,0)],
            ['name' => 'Anual (2x)', 'value' => '1000.00', 'class_per_week' => 2, 'duration' => 12, 'enabled' => rand(1,0)],
            ['name' => 'Anual (3x)', 'value' => '1100.00', 'class_per_week' => 3, 'duration' => 12, 'enabled' => rand(1,0)],
        ];


        $names = ['Mensal', 'Trimestral', 'Semestral', 'Anual', 'Promocional'];

        for($i=1;$i<10;$i++) {

            $plan = $names[rand(0, count($names)-1)];
            $cpw = rand(1,7);
            $dura = rand(1,12);

            Plan::create([
                'name' => $plan . ' ('.$cpw.'x)',
                'value' => rand(100, 1540),
                'class_per_week' => $cpw,
                'duration' => $dura,
                'enabled' => 1,
                'description' => 'Plano '.$plan.' com duração de '.$dura.' mes(es) e '.$cpw . ' aula(s) por semana'
            ]);

        }

        // foreach($plans as $plan) {

        //     Plan::create($plan);

        // }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Modality;
use Illuminate\Database\Seeder;

class ModalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modality::create(['name' => 'Pilates']);
        Modality::create(['name' => 'LPF']);
        Modality::create(['name' => 'Bundge Fusion']);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            PlanSeeder::class,
            StudentSeeder::class,
            InstructorSeeder::class,
            // RegistrationSeeder::class
            ExerciceSeeder::class,
            PaymentMethodSeeder::class,
            HolidaySeeder::class,
            ModalitySeeder::class
        ]);
    }
}

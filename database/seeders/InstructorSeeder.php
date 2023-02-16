<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\User;
use Faker\Factory;
use Faker\Provider\pt_BR\Person;
use Faker\Provider\pt_BR\PhoneNumber;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('pt-br');
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new PhoneNumber($faker));

        $max = 3;

        for($i=0;$i<=$max;$i++) {

            $nick = $faker->firstName;
            $name  = $nick . ' '.$faker->lastName;
            $email = $faker->unique()->email;

            $user = User::create([
                'cpf'       => $faker->unique()->cpf,
                'nickname' => $nick,
                'name'      => $name,
                'email'     => $email,
                'phone_wpp' => $faker->phoneNumber,
                'phone2'    => $faker->phoneNumber,
                'zipcode'   => $faker->postcode,
                'address'   => $faker->streetName,
                'number'    => $faker->buildingNumber,
                'district'  => $faker->city,
                'city'      => $faker->city,
                'state'     => $faker->stateAbbr,
                'gender'    =>  $faker->randomElement(['M', 'F']),
                'birth_date' => $faker->date()
            ]);

          
    
            $instructor = new Instructor();
            $instructor->enabled = rand(0,1);
            $instructor->user()->associate($user);
            $instructor->save();
          



        }
    }
}

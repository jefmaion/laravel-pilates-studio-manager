<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            ['name' => 'Cartão Débito', 'enabled' => 1],
            ['name' => 'Cartão Crédito', 'enabled' => 1],
            ['name' => 'Dinheiro', 'enabled' => 1],
            ['name' => 'Pix', 'enabled' => 1],
           
            

        ];



        foreach($methods as $method) {

            PaymentMethod::create($method);

        }
    }
}

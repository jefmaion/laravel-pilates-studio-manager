<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use App\Services\StudentService;
use Faker\Factory;
use Faker\Provider\pt_BR\Person;
use Faker\Provider\pt_BR\PhoneNumber;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            ['name' => 'Rosa Coan Bonugli', 'gender' => 'F', 'birth_date' => '1936-02-16', 'cpf' => '34779751896', 'address' => 'Rua Dom Humberto Mazzoni', 'number' => '315', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '19 99247-3123 '],
            ['name' => 'Eunice Neri Da Silva', 'gender' => 'F', 'birth_date' => '1957-07-28', 'cpf' => '18431816813', 'address' => 'Rua Batista Raffi', 'number' => '457', 'complement' => '', 'district' => 'NOVA AARECIDA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '99712-6981'],
            ['name' => 'Lucilene Belli De Oliveira', 'gender' => 'F', 'birth_date' => '1983-08-22', 'cpf' => '22262294852', 'address' => 'Rua Dr. Paulo Florence', 'number' => '604', 'complement' => '', 'district' => 'VILA ITÁLIA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '98846-0124'],
            ['name' => 'Suzel Galvão Briega', 'gender' => 'F', 'birth_date' => '1954-08-16', 'address' => 'Rua Dom Jaime De Barros Camara', 'number' => '202', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '3281-0052'],
            ['name' => 'Elaine Aparecida Nardez Mendes', 'gender' => 'F', 'birth_date' => '1969-05-15', 'address' => 'Rua Italia Burato', 'number' => '21', 'complement' => '', 'district' => '', 'city' => '', 'state' => '', 'phone_wpp' => '19.3289-4240/99675-5603'],
            ['name' => 'Dirce Aparecida De Oliveira Rodrigues', 'gender' => 'F', 'birth_date' => '1951-10-20', 'address' => 'Rua Papa Virgilio', 'number' => '106', 'complement' => '', 'district' => 'VILA PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19)32814358 '],
            ['name' => 'Renata T Silva', 'gender' => 'F', 'birth_date' => '1997-06-01', 'address' => 'R Dom Carlos Carmelo De Vasconcelos Mota', 'number' => '', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '19.98967-4693'],
            ['name' => 'Michele Cristina F. Z. Graf', 'gender' => 'F', 'birth_date' => '1981-03-30', 'cpf' => '31807257886', 'address' => 'Rua Papa São Fabião', 'number' => '300', 'complement' => '', 'district' => 'VILA PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19)994799925'],
            ['name' => 'Irene Martins Do Prado', 'gender' => 'F', 'birth_date' => '1945-03-04', 'cpf' => '18216204884', 'address' => 'Rua Dom Gilberto Pereira Lopes', 'number' => '185', 'complement' => '', 'district' => 'VILA PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '3281-2266'],
            ['name' => 'Lucia Helena Do Prado Souza', 'gender' => 'F', 'birth_date' => '1966-06-05', 'cpf' => '18216204885', 'address' => 'Rua Dom Augusto Alvaro Da Silva', 'number' => '264', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '99120-5684'],
            ['name' => 'Maria Da Penha Cagliari Pimenta ', 'gender' => 'F', 'birth_date' => '1957-06-22', 'address' => 'Rua Angela Palma Guartieri', 'number' => '407', 'complement' => '', 'district' => 'JD APARECIDA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '3281-0456'],
            ['name' => 'Danielle Farias Gomes', 'gender' => 'F', 'birth_date' => '1986-04-18', 'address' => 'Rua Papa São Marcelino', 'number' => '25', 'complement' => '', 'district' => 'PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19) 988200530'],
            ['name' => 'Sueli Aparecida Moreira Oliveira', 'gender' => 'F', 'birth_date' => '1961-06-26', 'cpf' => '21752804899', 'address' => 'Rua Papa São Lino ', 'number' => '32', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '19988445004'],
            ['name' => 'Amanda Rafaela Elias Afonso', 'gender' => 'F', 'birth_date' => '1994-06-05', 'address' => 'Avenida João Scarparo Neto', 'number' => '240', 'complement' => 'BL 9 APT 27 ', 'district' => '', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19) 987002039'],
            ['name' => 'Maria Apparecida B Grasseschi', 'gender' => 'F', 'birth_date' => '1942-10-05', 'address' => 'Rua Edmundo Panuncio', 'number' => '442', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '98739-1573'],
            ['name' => 'Cristiane Moreno Da Silva', 'gender' => 'F', 'birth_date' => '1973-06-11', 'cpf' => '25606912805', 'address' => 'Rua Papa São Calisto', 'number' => '35', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19) 982659162'],
            ['name' => 'Isabel Sanches Ruivo', 'gender' => 'F', 'birth_date' => '1951-12-06', 'address' => 'Av Papa João Paulo Ii', 'number' => '1222', 'complement' => 'BL B AP 33', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '99586-0220/3281-3770'],
            ['name' => 'Tania De Cassia Scatolin', 'gender' => 'F', 'birth_date' => '1971-05-22', 'cpf' => '14877801847', 'address' => 'Av Cardeal Dom Agnelo Rossi', 'number' => '?', 'complement' => 'BL F AP 14 SANTA ANA', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '992291797'],
            ['name' => 'Carinna Caetano', 'gender' => 'F', 'birth_date' => '1986-11-08', 'address' => 'Rua Maria Assunta Gualtieri De Camargo', 'number' => '41', 'complement' => '', 'district' => 'JARDIM ROSA LIMA II', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(11)947089242'],
            ['name' => 'Elaine Cristina Machado De Souza', 'gender' => 'F', 'birth_date' => '1975-05-21', 'cpf' => '25276134898', 'address' => 'Rua Wiliam Garcia, 235', 'number' => '235', 'complement' => '', 'district' => 'JD ACLIMAÇÃO', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19)98834-3989'],
            ['name' => 'Luzia Menatto Lacaia', 'gender' => 'F', 'birth_date' => '1950-05-22', 'address' => 'Rua São Tomé', 'number' => '291', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19)3281-3353'],
            ['name' => 'Maria De Lourdes Santoro Da Silva', 'gender' => 'F', 'birth_date' => '1960-03-23', 'address' => 'Rua Papa Santo Antero', 'number' => '85', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19) 99699-4142'],
            ['name' => 'Elizabeth Aparecida Donatto Oliveira', 'gender' => 'F', 'birth_date' => '1966-12-04', 'address' => 'Rua N. Sr. Da Penha', 'number' => '127', 'complement' => '', 'district' => 'PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '19981320175'],
            ['name' => 'Gislene Aparecida Nascimento Morari', 'gender' => 'F', 'birth_date' => '1971-04-11', 'address' => 'Rua B', 'number' => '31', 'complement' => '', 'district' => 'RECANTO DAS ARVORES (SÃO JUDAS II)', 'city' => 'SUMARÉ', 'state' => 'SP', 'phone_wpp' => '(19) 991131272'],
            ['name' => 'Nicolina Lio Cruz', 'gender' => 'F', 'birth_date' => '1951-12-12', 'address' => 'Rua João Carlos Do Amaral', 'number' => '266', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '3282-1086/981593735'],
            ['name' => 'Aparecida Closel', 'gender' => 'F', 'birth_date' => '1968-06-12', 'address' => 'R Dom Carllos Chiarlo', 'number' => '213', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19)989164101'],
            ['name' => 'Sandra Aparecida Dos Santos Rocha', 'gender' => 'F', 'birth_date' => '1966-02-13', 'address' => 'R Dom Gilberto Pereira Lopes', 'number' => '88', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19) 99450-0637'],
            ['name' => 'Neusa Ap Cardoso Carvalho ', 'gender' => 'F', 'birth_date' => '1958-05-06', 'address' => 'Rua Dom Vicente Scherer', 'number' => '292', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19)9911-69049'],
            ['name' => 'Neide Aparecida Facchini Tavares', 'gender' => 'F', 'birth_date' => '1958-06-17', 'cpf' => '93197292804', 'address' => 'Rua Papa São Vitor I', 'number' => '45', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '32816314/3365-7966'],
            ['name' => 'Maria Do Carmo Faria', 'gender' => 'F', 'birth_date' => '1955-06-08', 'address' => 'Rua Papa São Marcelino ', 'number' => '109', 'complement' => '', 'district' => 'VILA PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19)98770-1350'],
            ['name' => 'Alzira Moreira Da Silva', 'gender' => 'F', 'birth_date' => '1937-10-03', 'address' => 'Dom Antonio Maria Alves Siqueira', 'number' => '401', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '3281-1455'],
            ['name' => 'Vera Lucia Siqueira', 'gender' => 'F', 'birth_date' => '1986-05-04', 'address' => 'Rua Don Carlos Chiarlo', 'number' => '228', 'complement' => '', 'district' => 'VILA PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19) 981719504'],
            ['name' => 'Natalia Pandolfi De Oliveira Chinelato', 'gender' => 'F', 'birth_date' => '1976-01-28', 'address' => 'Rua Jesuíno Marcondes Machado', 'number' => '2201', 'complement' => 'BL 4 APTO 83', 'district' => 'CHÁCARA DA BARRA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '991141159'],
            ['name' => 'Maria Esmeralda', 'gender' => 'F', 'birth_date' => '1966-03-01', 'address' => 'Rua Dom Antonio Maria Alves Siqueira', 'number' => '270', 'complement' => '', 'district' => 'VILA PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => ''],
            ['name' => 'Gilmar De Araújo', 'gender' => 'M', 'birth_date' => '1960-10-29', 'address' => 'Rua 03, São Miguel Do Piaui', 'number' => '167', 'complement' => '', 'district' => 'CHÁC BOA VISTA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19)99187-3996'],
            ['name' => 'Lindiane Santana Da Silva', 'gender' => 'F', 'birth_date' => '1987-10-23', 'address' => 'Rua 09', 'number' => '16', 'complement' => '', 'district' => 'RECANTO DAS ARVORES (SÃO JUDAS II)', 'city' => 'SUMARÉ', 'state' => 'SP', 'phone_wpp' => '(19)98770-1344'],
            ['name' => 'Aparecida Donizete Alves Da Silva', 'gender' => 'F', 'birth_date' => '1967-12-28', 'cpf' => '10253383838', 'address' => 'R Dona Avelas Brandes Vilela ', 'number' => '231', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19)99129-2017'],
            ['name' => 'Marcia Cristina De Souza', 'gender' => 'F', 'birth_date' => '1972-12-27', 'address' => 'Rua Dom Augusto Alvaro Da Silva', 'number' => '264', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19)98770-1348'],
            ['name' => 'Quiteria Carlos Pereira', 'gender' => 'F', 'birth_date' => '1958-10-30', 'address' => 'Rua Santa Brigida', 'number' => '106', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19)994169894'],
            ['name' => 'Ananda', 'gender' => 'F', 'address' => '', 'number' => '', 'complement' => '', 'district' => '', 'city' => '', 'state' => '', 'phone_wpp' => ' 19 99677-1040'],
            ['name' => 'Camila Cardoso', 'gender' => 'F', 'birth_date' => '1993-06-27', 'address' => 'Rua Angela Palma Guartieri', 'number' => '602', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19)995412453/32815987'],
            ['name' => 'Cesar Soares Rodrigues', 'gender' => 'M', 'birth_date' => '1993-08-08', 'address' => 'Rua Antonio Pinto Pereira', 'number' => '?', 'complement' => '', 'district' => '?', 'city' => '?', 'state' => '?', 'phone_wpp' => '98280-2123'],
            ['name' => 'Ercília Maria B. Bastos', 'gender' => 'F', 'cpf' => '06858161848', 'address' => '', 'number' => '', 'complement' => '', 'district' => '', 'city' => '', 'state' => '', 'phone_wpp' => ' 19 99677-1040(FILHA)'],
            ['name' => 'Eva Regina Caetano Dos Santos Alves ', 'gender' => 'F', 'birth_date' => '1964-06-17', 'address' => '', 'number' => '', 'complement' => '', 'district' => '', 'city' => '', 'state' => '', 'phone_wpp' => '997996974'],
            ['name' => 'Lucineia Coutinho Costa', 'gender' => 'F', 'birth_date' => '1980-08-02', 'address' => 'Rua Dom Vicente ', 'number' => '56', 'complement' => '', 'district' => 'VL PADRE ANCHIETA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19) 98216-5448'],
            ['name' => 'Neuza Baboni Machado', 'gender' => 'F', 'birth_date' => '1948-11-21', 'address' => 'Rua Dom Vicente Scherer', 'number' => '232', 'complement' => '', 'district' => '', 'city' => '', 'state' => '', 'phone_wpp' => '(19) 99310-5496 '],
            ['name' => 'Pedro Vincenzo Chinelato ', 'gender' => 'M', 'birth_date' => '2013-02-22', 'address' => 'Rua Jesuíno Marcondes Machado', 'number' => '2201', 'complement' => 'BL 4 APTO 83', 'district' => 'CHÁCARA DA BARRA', 'city' => 'CAMPINAS', 'state' => 'SP', 'phone_wpp' => '(19)99114-1159 '],
            ['name' => 'Silvia Helena M. Faria', 'gender' => 'F', 'birth_date' => '1962-11-11', 'address' => '', 'number' => '', 'complement' => '', 'district' => '', 'city' => '', 'state' => '', 'phone_wpp' => ''],
            ['name' => 'Silvia Lopes Baião', 'gender' => 'F', 'birth_date' => '1956-01-28', 'address' => '', 'number' => '', 'complement' => '', 'district' => '', 'city' => '', 'state' => '', 'phone_wpp' => '98926-6702'],

        ];

        foreach ($data as $item) {
            $user = User::create($item);
            $student = new Student();
            $student->enabled = 1;
            $student->user()->associate($user);
            $student->save();
        }


        // $faker = Factory::create('pt-br');
        // $faker->addProvider(new Person($faker));
        // $faker->addProvider(new PhoneNumber($faker));

        // $max = 50;

        // for($i=0;$i<=$max;$i++) {

        //     $nick = $faker->firstName;
        //     $name  = $nick . ' '.$faker->lastName;
        //     $email = $faker->unique()->email;

        //     $user = User::create([
        //         'cpf'       => $faker->unique()->cpf,
        //         'name'      => $name,
        //         'nickname' => $nick,
        //         'email'     => $email,
        //         'phone_wpp' => $faker->phoneNumber,
        //         'phone2'    => $faker->phoneNumber,
        //         'zipcode'   => $faker->postcode,
        //         'address'   => $faker->streetName,
        //         'number'    => $faker->buildingNumber,
        //         'district'  => $faker->city,
        //         'city'      => $faker->city,
        //         'state'     => $faker->stateAbbr,
        //         'gender'    =>  $faker->randomElement(['M', 'F']),
        //         'birth_date' => $faker->date()
        //     ]);



        //     $student = new Student();
        //     $student->enabled = rand(0,1);
        //     $student->user()->associate($user);
        //     $student->save();




        // }
    }
}

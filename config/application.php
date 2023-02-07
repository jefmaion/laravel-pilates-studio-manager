<?php

return [

    'monthNames' => [
        1 => 'Janeiro', 
        2 => 'Fereveiro', 
        3 => 'Março', 
        4 => 'Abril', 
        5 => 'Maio', 
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro',
    ],

    'class_time' => [
        '07:00:00' => '07:00', 
        '08:00:00' => '08:00', 
        '09:00:00' => '09:00',
        '10:00:00' => '10:00',
        '11:00:00' => '11:00',
        '12:00:00' => '12:00',
        '13:00:00' => '13:00',
        '14:00:00' => '14:00',
        '15:00:00' => '15:00',
        '16:00:00' => '16:00',
        '17:00:00' => '17:00',
        '18:00:00' => '18:00',
        '19:00:00' => '19:00',
        '20:00:00' => '20:00'
    ],

    'weekdays' => [
        1 => 'Segunda-Feira', 
        2 => 'Terça-Feira', 
        3 => 'Quarta-Feira', 
        4 => 'Quinta-Feira', 
        5 => 'Sexta-Feira', 
        6 => 'Sábado'
    ],

    'classTypes' => [

        'AN' => [
            'label' => 'Aula Normal',
            'color' => 'primary'
        ],

        'RP' => [
            'label' => 'Reposição',
            'color' => 'warning'
        ],

        'AE' => [
            'label' => 'Aula Experimental',
            'color' => 'info'
        ],
    ],

    'classStatus' => [
        0 => [
            'label' => 'Agendada',
            'color' => 'primary'
        ],

        1 => [
            'label' => 'Realizada',
            'color' => 'success'
        ],

        2 => [
            'label' => 'Falta Justificada',
            'color' => 'warning'
        ],

        3 => [
            'label' => 'Falta',
            'color' => 'danger'
        ],

    ]

];
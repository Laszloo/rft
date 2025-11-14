<?php

namespace App\Config;

final class Application
{
    public const STATUS = [
        'folyamatban' => [
            'label' => 'Függőben',
            'badge' => 'secondary',
        ],
        'fizetve' => [
            'label' => 'Fizetve',
            'badge' => 'success',
        ],
        'szallitva' => [
            'label' => 'Kiszállítva',
            'badge' => 'primary',
        ],
        'teljesitve' => [
            'label' => 'Lezárva',
            'badge' => 'success',
        ],
        'torolve' => [
            'label' => 'Törölve',
            'badge' => 'danger',
        ],
    ];
}

<?php

declare(strict_types=1);

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

    public const MESSAGES_TYPES = [
        'success' => 'success',
        'warning' => 'warning',
        'error' => 'danger',
    ];

    public const MESSAGES_SHOW_TIME = 2;
}

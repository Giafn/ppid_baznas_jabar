<?php

return [
    [
        'name' => 'Dashboard',
        'url' => 'home',
        'icon' => 'fas fa-home',
        'code' => 'dashboard',
    ],
    [
        'name' => 'Setting Page',
        'url' => '',
        'icon' => 'fa fa-archive',
        'code' => 'master',
        'child' => [
            [
                'name' => 'Landing page',
                'url' => 'setting-page/landing',
                'code' => ''
            ],
            [
                'name' => 'Eskul',
                'url' => 'master/eskul',
                'code' => 'eskul'
            ],
            [
                'name' => 'Jadwal',
                'url' => 'master/jadwal',
                'code' => 'jadwal'
            ],
        ]

    ],
    [
        'name' => 'Anggota',
        'url' => 'anggota',
        'icon' => 'fas fa-users',
        'code' => 'anggota',
    ],
    [
        'name' => 'Absensi',
        'url' => 'list-absensi',
        'icon' => 'fas fa-book-reader',
        'code' => 'absensi',
    ],
    [
        'name' => 'Dokumentasi',
        'url' => 'list-dokumentasi',
        'icon' => 'fas fa-camera',
        'code' => 'dokumentasi',
    ],
];
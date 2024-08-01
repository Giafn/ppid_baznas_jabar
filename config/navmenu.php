<?php

return [
    [
        'name' => 'Dashboard',
        'url' => 'admin/home',
        'icon' => 'fas fa-home',
        'code' => 'dashboard',
    ],
    [
        'name' => 'Landing Page',
        'url' => 'admin/landing-page-setting',
        'icon' => 'fas fa-columns',
        'code' => 'landing-page',
    ],
    [
        'name' => 'General Page',
        'url' => '',
        'icon' => 'fa fa-archive',
        'code' => 'admin.general',
        'child' => [
            [
                'name' => 'Profil',
                'url' => 'admin/general/profile',
                'code' => 'admin.general.profile'
            ],
            [
                'name' => 'Visi Misi',
                'url' => 'admin/general/visi-misi',
                'code' => 'admin.general.visi-misi'
            ],
            [
                'name' => 'Tugas Dan Fungsi',
                'url' => 'admin/general/tugas-fungsi',
                'code' => 'admin.general.tugas-fungsi'
            ],
            [
                'name' => 'Struktur Organisasi PPID',
                'url' => 'admin/general/struktur-organisasi',
                'code' => 'admin.general.struktur-organisasi'
            ],
        ]
    ]
];
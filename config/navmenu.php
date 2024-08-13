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
                'name' => 'Struktur Organisasi',
                'url' => 'admin/general/struktur-organisasi',
                'code' => 'admin.general.struktur-organisasi'
            ],
        ]
    ],
    [
        'name' => 'Layanan Informasi',
        'url' => '',
        'icon' => 'fas fa-sitemap',
        'code' => 'admin.layanan-informasi',
        'child' => [
            [
                'name' => 'Formulir',
                'url' => 'admin/layanan-informasi/formulir',
                'code' => 'admin.layanan-informasi.formulir'
            ],
            [
                'name' => 'List Items',
                'url' => 'admin/layanan-informasi/list',
                'code' => 'admin.layanan-informasi.list'
            ]
        ]
    ],
    [
        'name' => 'Informasi Publik',
        'url' => '',
        'icon' => 'fas fa-info-circle',
        'code' => 'admin.informasi-publik',
        'child' => [
            [
                'name' => 'Berkala',
                'url' => 'admin/informasi-publik/berkala',
                'code' => 'admin.informasi-publik.berkala'
            ],
            [
                'name' => 'Serta Merta',
                'url' => 'admin/informasi-publik/serta-merta',
                'code' => 'admin.informasi-publik.serta-merta'
            ],
            [
                'name' => 'Setiap Saat',
                'url' => 'admin/informasi-publik/setiap-saat',
                'code' => 'admin.informasi-publik.setiap-saat'
            ]
        ]
    ],
    // custom page
    [
        'name' => 'Halaman',
        'url' => '',
        'icon' => 'fas fa-file-alt',
        'code' => 'admin.custom-page',
        'child' => [
            [
                'name' => 'Katagori Halaman',
                'url' => 'admin/custom-page/kategori',
                'code' => 'admin.custom-page.kategori'
            ],
            [
                'name' => 'List Halaman',
                'url' => 'admin/custom-page',
                'code' => 'admin.custom-page.page'
            ]
        ]
    ],
    // regulasi
    [
        'name' => 'Regulasi',
        'url' => 'admin/regulasi',
        'icon' => 'fas fa-book',
        'code' => 'admin.regulasi',
    ],
    // tender
    [
        'name' => 'Tender',
        'url' => 'admin/tender',
        'icon' => 'fa-solid fa-handshake',
        'code' => 'admin.tender',
    ],
    // laporan
    [
        'name' => 'Laporan',
        'url' => 'admin/laporan',
        'icon' => 'fas fa-file-alt',
        'code' => 'admin.laporan',
    ],
    // faq
    [
        'name' => 'FAQ',
        'url' => 'admin/faqs',
        'icon' => 'fas fa-question-circle',
        'code' => 'admin.faq',
    ],
    // setting
    [
        'name' => 'Setting',
        'url' => '/admin/setting',
        'icon' => 'fas fa-cogs',
        'code' => 'admin.setting',
    ],
        

];
<?php
// Aside menu
return [

    'items' => [
        // Dashboard
        [
            'title' => 'Dashboard',
            'root' => true,
            'icon' => 'flaticon-home',
//            'page' => '/dashboard',
            'route_name' => 'dashboard',
            'new-tab' => false,
        ],

        // Custom
        [
            'separator' => '',
        ],
        [
            'title' => 'Tes',
            'root' => true,
            'icon' => 'flaticon-open-box',
//            'page' => '/dashboard/permohonan',
            'route_name' => 'dashboard.tes',
            'new-tab' => false,
        ],
        [
            'title' => 'Soal',
            'root' => true,
            'icon' => 'flaticon-book',
//            'page' => '/dashboard/permohonan',
            'route_name' => 'dashboard.soal',
            'new-tab' => false,
        ],
        [
            'title' => 'Peserta',
            'root' => true,
            'icon' => 'flaticon-user',
//            'page' => '/dashboard/permohonan',
            'route_name' => 'dashboard.peserta',
            'new-tab' => false,
        ],
        [
            'separator' => '',
        ],
        [
            'title' => 'Setting',
            'root' => true,
            'icon' => ' flaticon-settings',
//            'page' => '/dashboard/permohonan',
            'route_name' => 'dashboard.setting',
            'new-tab' => false,
        ],
        [
            'title' => 'User',
            'root' => true,
            'icon' => ' flaticon2-user',
//            'page' => '/dashboard/permohonan',
            'route_name' => 'dashboard.user',
            'new-tab' => false,
        ],
        [
            'separator' => '',
        ],
        [
            'title' => 'Edit Profile',
            'root' => true,
            'icon' => ' flaticon2-edit',
//            'page' => '/dashboard/permohonan',
            'route_name' => 'dashboard.profile',
            'new-tab' => false,
        ],
        [
            'title' => 'Aplikasi',
            'root' => true,
            'icon' => ' flaticon2-world',
//            'page' => '/dashboard/permohonan',
            'route_name' => 'aktivasi',
            'new-tab' => false,
        ],
    ]
];

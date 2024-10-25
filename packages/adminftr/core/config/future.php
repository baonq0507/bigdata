<?php

return [
    'future' => [
        'title' => 'Future',
        'cache' => [
            'enabled' => true,
            'duration' => 60,
        ],
        'route' => [
            'prefix' => 'admin',
            'as' => 'admin.',
            'middleware' => [
                'web',
                'auth',
            ],
        ],
        'messages' => true,
        'notifications' => true,
        'dashboard' => [
            'widgets' => [
//                Stat::make('User')
//                    ->color('green')
//                    ->callback(function ($stat, $startDate, $endDate) {
//                        $stat->value = User::whereBetween('created_at', [$startDate, $endDate])->count();
//                        $total = User::whereMonth('created_at', now()->month)->count();
//                        if ($stat->value > 0) {
//                            $stat->description = 'Có '.$stat->value.' người dùng mới';
//                        } else {
//                            $stat->description = 'Không có người dùng mới';
//                        }
//                        $stat->subDescription = [
//                            'color' => $stat->value > $total ? 'green' : 'red',
//                            'title' => $total == 0 ? 'không thay đổi so với tháng' : ($stat->value > $total ? 'Tăng ' : 'Giảm ').number_format(($stat->value - $total) / $total * 100, 2).'%',
//                            'icon' => $stat->value > $total ? 'fa fa-arrow-up' : 'fa fa-arrow-down',
//                        ];
//                    })->dropdown('Lọc theo ngày', [[
//                        'title' => 'Hôm nay',
//                        'attributes' => [
//                            'wire:click' => 'filter("today")',
//                        ],
//                    ],
//                    ]),
//                Stat::make('Quyền hạn')
//                    ->color('blue')
//                    ->callback(function ($stat, $startDate, $endDate) {
//                        $stat->value = Permission::count();
//                        $stat->description = 'Tổng số quyền';
//                    }),
//                Stat::make('Thông báo')
//                    ->color('yellow')
//                    ->callback(function ($stat, $startDate, $endDate) {
//                        $stat->value = Auth::user()->unreadNotifications->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
//                        $stat->description = 'Tổng số thông báo chưa đọc';
//                    }),
            ],
            'description' => 'demo description',
            'title' => 'demo',
        ],
    ],
];

<?php
return [
    'frontend' => [
        'noImage' => '/frontend/images/noimage.jpg',
        'userNoImage' => '/frontend/images/usernoimage.png',
    ],
    'backend' => [
        'noImage' => '/admin_asset/images/noimage.png',
        'userNoImage' => '/admin_asset/images/usernoimage.png',
    ],
    'typeExercise' => [
        1 => 'Trắc nghiệm',
        2 =>  'Bài tập SGK'
    ],
    'typeQuestion' => [
        1 => 'Trắc nghiệm',
        2 =>  'Tự luận'
    ],
    'statusPost' => [
        1 => [
            'name' => 'Đăng bài'
        ],
        2 => [
            'name' => 'Gửi duyệt'
        ],
        3 => [
            'name' => 'Đã duyệt'
        ],
        4 => [
            'name' => 'Trả lại'
        ],
        5 => [
            'name' => 'Đã sửa (bị trả lại)'
        ]
    ]
];

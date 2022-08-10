<?php
    return [
        'typePoint' => [
            1 => [
                'type' => 1,
                'name' => 'Đã thanh toán',

            ],
            2 => [
                'type' => 2,
                'name' => 'Điểm mua văn bản',
            ],
        ],


        // trạng thái pay
        'typePay' => [
            1 => [
                'type' => 1,
                'name' => 'Đang chờ xử lý',
            ],
            2 => [
                'type' => 2,
                'name' => 'Đã rút thành công',
            ],
            3 =>  [
                'type' => 3,
                'name' => 'Rút không thành công. Đã hoàn điểm lại',
            ],
        ],
        'typeStore' => [
            1 => [
                'type' => 1,
                'name' => 'Nhập kho',

            ],
            2 => [
                'type' => 2,
                'name' => 'Đã đặt hàng đang chờ xuất kho',
            ],
            3 =>  [
                'type' => 3,
                'name' => 'Xuất kho',
            ],
        ],
        // thời gian mở cổng rút điểm
        'datePay'=>[
            'start'=>1,
            'end'=>30
        ],
        // số điểm bắn mắc định
        'transferPointDefault'=>10,
        // đơn vị của điểm
        'pointUnit'=>'Điểm',
        'pointToMoney'=>1000,
        'namePointDefault'=>"Phạm Văn Hưng",
    ];

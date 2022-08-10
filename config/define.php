<?php
return [
    'format' => [
        'default' => [
            'date'          => 'd/m/y',
            'date_time'     => 'd/m/y H:i:s',
            'date_csv'      => 'dmy'
        ],
        'display' => [
            'date'          => 'Y-m-d H:i:s',
            'year_month'    => 'Y-m',
        ],
        'time' => 'H:i:s',
    ],
    'csv' => [
        'order' => [
            'title'          => 'order',
            'chunk_download' => 100,
            'title_header' => [
                'id'                    => 'Id',
                'order_code'            => 'Mã khách hàng',
                'customer_name'         => 'Tên',
                'customer_phone'        => 'Số điện thoại',
                'customer_address'      => 'Địa chỉ',
                'user_id'               => 'User id',
                'total_money'           => 'Tổng tiền',
                'shipping_fee'          => 'Tiền Ship',
                'real_money'            => 'Tiền COD',
                // 'condition_id'          => 'Condition id',
                'note'                  => 'Ghi chú',
                // 'payment_id'            => 'Payment id',
                // 'shipper_id'            => 'Shipper id',
                // 'package_sum_mass'      => 'Package sum mass',
                // 'package_long'          => 'Package long',
                // 'package_wide'          => 'Package wide',
                // 'package_high'          => 'Package high',
                // 'debt'                  => 'Debt',
                // 'refund'                => 'Refund',
                'created_at'            => 'Ngày mua hàng'
            ],
        ],

        'product' => [
            'title'          => 'product',
            'chunk_download' => 100,
            'title_header' => [
                'id'            => 'Id',
                'order_code'    => 'Order code',
                'product_title' => 'Product name',
                'product_image' => 'Product image',
                'product_code'  => 'Product code',
                'product_money' => 'Product money',
                'product_mass'  => 'Product mass',
                'product_qty'   => 'Product qty',
                'created_at'    => 'Created at'
            ]
        ]
    ],
];

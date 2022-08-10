<?php
return [
    'access' => [
        'category-product-list' => 'category_product_list',
        'category-product-add' => 'category_product_add',
        'category-product-edit' => 'category_product_edit',
        'category-product-delete' => 'category_product_delete',

        'category-post-list' => 'category_post_list',
        'category-post-add' => 'category_post_add',
        'category-post-edit' => 'category_post_edit',
        'category-post-delete' => 'category_post_delete',

        // 'slider-list' => 'slider_list',
        // 'slider-add' => 'slider_add',
        // 'slider-edit' => 'slider_edit',
        // 'slider-delete' => 'slider_delete',

        // 'menu-list' => 'menu_list',
        // 'menu-add' => 'menu_add',
        // 'menu-edit' => 'menu_edit',
        // 'menu-delete' => 'menu_delete',

        'product-list' => 'product_list',
        'product-add' => 'product_add',
        'product-edit' => 'product_edit',
        'product-delete' => 'product_delete',

        'post-list' => 'post_list',
        // danh sách bài viết của mình
        'post-list-self' => 'post_list_self',
        'post-add' => 'post_add',
        // chỉ sửa khi đã duyệt
        'post-edit' => 'post_edit',
        // luôn được phép sửa
        'post-edit-every' => 'post_edit_every',
        // không cho phép sửa bài viết đã duyệt
        'post-da-duyet' => 'post_da_duyet',
        // sửa bài viết của bản thân
        'post-edit-self' => 'post_edit_self',
        // gửi duyệt bài
        'post-send-duyet' => 'post_send_duyet',
        // duyệt bài
        'post-duyet' => 'post_duyet',
        // hạ bài
        'post-active' => 'post_active',
        // trả bài
        'post-trabai' => 'post_trabai',
        // bài viết nổi bật
        'post-hot' => 'post_hot',
        'post-delete' => 'post_delete',

        'setting-list' => 'setting_list',
        'setting-add' => 'setting_add',
        'setting-edit' => 'setting_edit',
        'setting-delete' => 'setting_delete',

        'admin-user-list' => 'admin_user_list',
        'admin-user-add' => 'admin_user_add',
        'admin-user-edit' => 'admin_user_edit',
        'admin-user-delete' => 'admin_user_delete',

        'admin-user_frontend-list' => 'admin_user_frontend_list',
        'admin-user_frontend-add' => 'admin_user_frontend_add',
        'admin-user_frontend-edit' => 'admin_user_frontend_edit',
        'admin-user_frontend-delete' => 'admin_user_frontend_delete',
        'admin-user_frontend-active' => 'admin_user_frontend_active',
        'admin-user_frontend-transfer-point' => 'admin_user_frontend_transfer_point',
        'admin-user_frontend-nap' => 'admin_user_frontend_nap',

         'role-list' => 'role_list',
         'role-add' => 'role_add',
         'role-edit' => 'role_edit',
         'role-delete' => 'role_delete',

         'permission-list' => 'permission_list',
         'permission-add' => 'permission_add',
         'permission-edit' => 'permission_edit',
         'permission-delete' => 'permission_delete',
        /*
        'pay-list' => 'pay_list',
        'pay-add' => 'pay_add',
        'pay-edit' => 'pay_edit',
        'pay-delete' => 'pay_delete',
        'pay-update-draw-point' => 'pay_update_draw_point',
        'pay-export-excel' => 'pay_export_excel',

        'bank-list' => 'bank_list',
        'bank-add' => 'bank_add',
        'bank-edit' => 'bank_edit',
        'bank-delete' => 'bank_delete',


        'store-list' => 'store_list',
        'store-input' => 'store_input',
        // 'store-edit'=>'store_output',


        'transaction-list' => 'transaction_list',
        'transaction-status' => 'transaction_status',
        'transaction-delete' => 'transaction_delete',

        // chương trình
        'category-program-list' => 'category_program_list',
        'category-program-add' => 'category_program_add',
        'category-program-edit' => 'category_program_edit',
        'category-program-delete' => 'category_program_delete',

        // chương trình
        'program-list' => 'program_list',
        'program-add' => 'program_add',
        'program-edit' => 'program_edit',
        'program-delete' => 'program_delete',
        // galaxy


        // exam
        'category-exam-list' => 'category_exam_list',
        'category-exam-add' => 'category_exam_add',
        'category-exam-edit' => 'category_exam_edit',
        'category-exam-delete' => 'category_exam_delete',

        'exam-list' => 'exam_list',
        'exam-add' => 'exam_add',
        'exam-edit' => 'exam_edit',
        'exam-delete' => 'exam_delete',
        */


        'category-galaxy-list' => 'category_galaxy_list',
        'category-galaxy-add' => 'category_galaxy_add',
        'category-galaxy-edit' => 'category_galaxy_edit',
        'category-galaxy-delete' => 'category_galaxy_delete',

        'galaxy-list' => 'galaxy_list',
        'galaxy-add' => 'galaxy_add',
        'galaxy-edit' => 'galaxy_edit',
        'galaxy-delete' => 'galaxy_delete',

        // giấy giới thiệu

        'about-list' => 'about_list',
        'about-add' => 'about_add',
        'about-edit' => 'about_edit',
        'about-delete' => 'about_delete',

        'view-phong-vien' => 'view_phong_vien',
        'view-bien-tap' => 'view_bien_tap',
        'view-thu-ky' => 'view_thu_ky',
        'view-pho-tong' => 'view_pho_tong',
        'view-tong-bien-tap' => 'view_tong_bien_tap',

        'order-management-list' => 'order_management_list',
    ],
    'table_module' => [
        'category_product',
        'category_post',
        'slider',
        'menu',
        'product',
        'post',
        'setting',
        'admin',
        'role',
        'permission',
        'order_management'
    ],
    'module_childrent' => [
        'list',
        'add',
        'edit',
        'delete',
    ],
];

<?php
return [
    'programs' => [
        'type'=>[
            1 => 'Lý thuyết',
            2 => 'Soạn bài',
        ],
        'routeLoadParent'=> 'admin.program.loadParentParagraphProgram',
        'routeStore'=> 'admin.program.storeParagraphProgram',
        'routeUpdate'=> 'admin.program.updateParagraphProgram',
        'routeDelete' => 'admin.program.destroyParagraphProgram',
        'routeEdit' => 'admin.program.loadEditParagraphProgram',
        'nameRelation'=>'program'
    ],
    'posts' => [
        'type' => [
            1 => 'Đoạn văn',
        ],
        'routeLoadParent' => 'admin.post.loadParentParagraphPost',
        'routeStore' => 'admin.post.storeParagraphPost',
        'routeUpdate' => 'admin.post.updateParagraphPost',
        'routeDelete' => 'admin.post.destroyParagraphPost',
        'routeEdit' => 'admin.post.loadEditParagraphPost',
        'nameRelation' => 'post'
    ],
    'category_posts' => [
        'type' => [
            1 => 'Banner',
        ],
        'routeLoadParent' => 'admin.categorypost.loadParentParagraphCategoryPost',
        'routeStore' => 'admin.categorypost.storeParagraphCategoryPost',
        'routeUpdate' => 'admin.categorypost.updateParagraphCategoryPost',
        'routeDelete' => 'admin.categorypost.destroyParagraphCategoryPost',
        'routeEdit' => 'admin.categorypost.loadEditParagraphCategoryPost',
        'nameRelation' => 'category'
    ],
];

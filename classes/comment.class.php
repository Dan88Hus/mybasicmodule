<?php

class CommentTest extends ObjectModel  {
    public $id;
    public $user_id;
    public $comment;

    //overriding
    public static $definition = [
        'table' => _DB_PREFIX_ . 'testcomment',
        'primary' => 'id',
        'multilang' => true,
        'multilang_shop' => true,
        'fields' =>[
            'user_id' => [
                'type' => self::TYPE_INT,
                'size' => 11,
                'validate' => 'isunsignedInt',
                'required' => true,
            ],
            'comment' => [
                'type' => self::TYPE_STRING,
                'size' => 255,
                'validate' => 'isCleanHtml',
                'required' => true,
            ]

            ] //belong to fields


    ];

       

}
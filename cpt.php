<?php
/**
 * カスタム投稿タイプ：導入実績(b_case) / お客様の声(b_voice)
 */
if (!defined('ABSPATH')) exit;

add_action('init', function () {

    // 導入実績
    register_post_type('b_case', [
        'labels' => [
            'name'          => '導入実績',
            'singular_name' => '導入実績',
            'add_new'       => '新規追加',
            'add_new_item'  => '導入実績を追加',
            'edit_item'     => '導入実績を編集',
            'all_items'     => '導入実績一覧',
        ],
        'public'        => true,
        'has_archive'   => true,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-awards',
        'supports'      => ['title', 'thumbnail'],
        'rewrite'       => ['slug' => 'cases'],
        'show_in_rest'  => true,
    ]);

    // お客様の声
    register_post_type('b_voice', [
        'labels' => [
            'name'          => 'お客様の声',
            'singular_name' => 'お客様の声',
            'add_new'       => '新規追加',
            'add_new_item'  => 'お客様の声を追加',
            'edit_item'     => 'お客様の声を編集',
            'all_items'     => 'お客様の声一覧',
        ],
        'public'        => true,
        'has_archive'   => false,
        'menu_position' => 6,
        'menu_icon'     => 'dashicons-format-quote',
        'supports'      => ['title', 'thumbnail'],
        'rewrite'       => ['slug' => 'voice'],
        'show_in_rest'  => true,
    ]);
});

/* 「導入サービス」用の選択肢（共通） */
function bdot_service_choices() {
    return [
        'job'   => 'Boost JOB（採用）',
        'site'  => 'Boost SITE（Web）',
        'media' => 'Boost MEDIA（SNS）',
        'film'  => 'Boost FILM（動画）',
        'gbp'   => 'Boost GBP（MEO）',
        'ai'    => 'Boost AI（AI）',
    ];
}

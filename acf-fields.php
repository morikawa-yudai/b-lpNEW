<?php
/**
 * ACFフィールドをコードで登録（管理画面で手動作成不要）
 * ACFが有効なときのみ実行。
 */
if (!defined('ABSPATH')) exit;

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;

    /* ============ サイト設定（オプションページ） ============ */
    acf_add_local_field_group([
        'key' => 'group_b_options',
        'title' => 'B. サイト設定',
        'fields' => [
            ['key'=>'f_hero_tab','label'=>'HERO','type'=>'tab'],
            ['key'=>'f_hero_title','label'=>'メインコピー','name'=>'hero_title','type'=>'textarea','rows'=>3,'placeholder'=>"企業の成長に必要な\nサービスを、\nワンストップで。"],
            ['key'=>'f_hero_sub','label'=>'サブコピー','name'=>'hero_sub','type'=>'textarea','rows'=>3],
            ['key'=>'f_hero_video','label'=>'背景動画（任意・mp4）','name'=>'hero_video','type'=>'file','return_format'=>'url','mime_types'=>'mp4'],

            ['key'=>'f_about_tab','label'=>'ABOUT','type'=>'tab'],
            ['key'=>'f_about_title','label'=>'見出し','name'=>'about_title','type'=>'textarea','rows'=>2],
            ['key'=>'f_about_body','label'=>'本文','name'=>'about_body','type'=>'textarea','rows'=>4],

            ['key'=>'f_ach_tab','label'=>'実績数値','type'=>'tab'],
            ['key'=>'f_ach_companies','label'=>'導入企業数','name'=>'ach_companies','type'=>'number','default_value'=>200],
            ['key'=>'f_ach_services','label'=>'導入サービス数','name'=>'ach_services','type'=>'number','default_value'=>250],
            ['key'=>'f_ach_retention','label'=>'継続率(%)','name'=>'ach_retention','type'=>'number','default_value'=>95],

            ['key'=>'f_cta_tab','label'=>'CTA / SEO','type'=>'tab'],
            ['key'=>'f_cta_title','label'=>'CTA見出し','name'=>'cta_title','type'=>'textarea','rows'=>2],
            ['key'=>'f_cta_body','label'=>'CTA本文','name'=>'cta_body','type'=>'textarea','rows'=>3],
            ['key'=>'f_cta_url','label'=>'お問い合わせURL','name'=>'cta_url','type'=>'url'],
            ['key'=>'f_meta_desc','label'=>'meta description','name'=>'meta_description','type'=>'textarea','rows'=>2],

            ['key'=>'f_svc_tab','label'=>'サービス内容','type'=>'tab'],
            ['key'=>'f_services','label'=>'サービス（6種）','name'=>'services','type'=>'repeater','button_label'=>'サービスを追加','layout'=>'block',
             'sub_fields'=>[
                ['key'=>'f_s_key','label'=>'キー','name'=>'key','type'=>'select','choices'=>['job'=>'job','site'=>'site','media'=>'media','film'=>'film','gbp'=>'gbp','ai'=>'ai'],'wrapper'=>['width'=>20]],
                ['key'=>'f_s_name','label'=>'サービス名','name'=>'name','type'=>'text','wrapper'=>['width'=>40]],
                ['key'=>'f_s_role','label'=>'役割（サブ）','name'=>'role','type'=>'text','wrapper'=>['width'=>40]],
                ['key'=>'f_s_catch','label'=>'キャッチ','name'=>'catch','type'=>'textarea','rows'=>2],
                ['key'=>'f_s_body','label'=>'本文','name'=>'body','type'=>'textarea','rows'=>3],
                ['key'=>'f_s_feats','label'=>'特徴（1行1項目）','name'=>'feats','type'=>'textarea','rows'=>5],
             ]],
        ],
        'location' => [[['param'=>'options_page','operator'=>'==','value'=>'b-settings']]],
    ]);

    /* ============ 導入実績 ============ */
    acf_add_local_field_group([
        'key' => 'group_b_case',
        'title' => '導入実績の詳細',
        'fields' => [
            ['key'=>'fc_logo','label'=>'企業ロゴ','name'=>'logo','type'=>'image','return_format'=>'url','wrapper'=>['width'=>50]],
            ['key'=>'fc_company','label'=>'企業名','name'=>'company','type'=>'text','wrapper'=>['width'=>50]],
            ['key'=>'fc_industry','label'=>'業種','name'=>'industry','type'=>'text','wrapper'=>['width'=>33]],
            ['key'=>'fc_area','label'=>'地域','name'=>'area','type'=>'text','wrapper'=>['width'=>33]],
            ['key'=>'fc_date','label'=>'導入年月','name'=>'intro_date','type'=>'text','placeholder'=>'2025.04','wrapper'=>['width'=>34]],
            ['key'=>'fc_services','label'=>'導入サービス','name'=>'services','type'=>'checkbox','choices'=>bdot_service_choices()],
            ['key'=>'fc_intro','label'=>'紹介文','name'=>'intro','type'=>'textarea','rows'=>4],
            ['key'=>'fc_result','label'=>'成果テキスト','name'=>'result','type'=>'text','placeholder'=>'問い合わせ数 月3件 → 月22件'],
            ['key'=>'fc_url','label'=>'ホームページURL（任意）','name'=>'url','type'=>'url'],
            ['key'=>'fc_visible','label'=>'表示する','name'=>'visible','type'=>'true_false','default_value'=>1,'ui'=>1],
        ],
        'location' => [[['param'=>'post_type','operator'=>'==','value'=>'b_case']]],
    ]);

    /* ============ お客様の声 ============ */
    acf_add_local_field_group([
        'key' => 'group_b_voice',
        'title' => 'お客様の声の詳細',
        'fields' => [
            ['key'=>'fv_company','label'=>'会社名','name'=>'company','type'=>'text','wrapper'=>['width'=>50]],
            ['key'=>'fv_name','label'=>'お名前','name'=>'person','type'=>'text','wrapper'=>['width'=>25]],
            ['key'=>'fv_role','label'=>'役職','name'=>'role','type'=>'text','wrapper'=>['width'=>25]],
            ['key'=>'fv_photo','label'=>'顔写真（任意）','name'=>'photo','type'=>'image','return_format'=>'url','wrapper'=>['width'=>50]],
            ['key'=>'fv_service','label'=>'利用サービス','name'=>'service','type'=>'select','choices'=>bdot_service_choices(),'wrapper'=>['width'=>50]],
            ['key'=>'fv_comment','label'=>'コメント','name'=>'comment','type'=>'textarea','rows'=>4],
            ['key'=>'fv_rating','label'=>'評価（星）','name'=>'rating','type'=>'select','choices'=>[5=>'★★★★★',4=>'★★★★☆',3=>'★★★☆☆',2=>'★★☆☆☆',1=>'★☆☆☆☆'],'default_value'=>5,'wrapper'=>['width'=>50]],
            ['key'=>'fv_visible','label'=>'表示する','name'=>'visible','type'=>'true_false','default_value'=>1,'ui'=>1,'wrapper'=>['width'=>50]],
        ],
        'location' => [[['param'=>'post_type','operator'=>'==','value'=>'b_voice']]],
    ]);
});

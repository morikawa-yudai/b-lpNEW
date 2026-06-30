<?php
/**
 * B. Service LP — functions.php
 */
if (!defined('ABSPATH')) exit;

define('BDOT_VER', '1.0.0');

/* ---------- テーマサポート ---------- */
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('automatic-feed-links');
    register_nav_menus([
        'primary' => 'グローバルナビ',
        'footer'  => 'フッターナビ',
    ]);
});

/* ---------- アセット ---------- */
add_action('wp_enqueue_scripts', function () {
    // フォント
    wp_enqueue_style(
        'bdot-fonts',
        'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Zen+Kaku+Gothic+New:wght@400;500;700;900&display=swap',
        [], null
    );
    // メインCSS
    wp_enqueue_style('bdot-main', get_template_directory_uri() . '/assets/css/main.css', [], BDOT_VER);

    // GSAP（CDN）
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], '3.12.5', true);
    wp_enqueue_script('gsap-st', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', ['gsap'], '3.12.5', true);

    // メインJS
    wp_enqueue_script('bdot-main', get_template_directory_uri() . '/assets/js/main.js', ['gsap', 'gsap-st'], BDOT_VER, true);

    // PHP → JS へサービスデータを受け渡し（ACFで上書き可能）
    wp_localize_script('bdot-main', 'B_DATA', [
        'services' => bdot_get_services(),
    ]);
});

/* ---------- 分割ファイル ---------- */
require get_template_directory() . '/inc/cpt.php';
require get_template_directory() . '/inc/acf-fields.php';

/* ---------- ACF 未導入時の管理画面アラート ---------- */
add_action('admin_notices', function () {
    if (!class_exists('ACF')) {
        echo '<div class="notice notice-warning"><p><strong>B. テーマ：</strong> Advanced Custom Fields（ACF）を有効化すると、HERO・実績数値・導入実績・お客様の声を管理画面から編集できます。</p></div>';
    }
});

/* ---------- ACFオプションページ ---------- */
add_action('acf/init', function () {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'B. サイト設定',
            'menu_title' => 'B. サイト設定',
            'menu_slug'  => 'b-settings',
            'capability' => 'edit_posts',
            'icon_url'   => 'dashicons-superhero',
            'position'   => 2,
        ]);
    }
});

/* ---------- ヘルパー：option取得（ACF無しでもフォールバック） ---------- */
function bdot_opt($key, $fallback = '') {
    if (function_exists('get_field')) {
        $v = get_field($key, 'option');
        if ($v !== null && $v !== '' && $v !== false) return $v;
    }
    return $fallback;
}

/* ---------- サービス6種（ACFリピーターで上書き可・無ければ既定値） ---------- */
function bdot_get_services() {
    $defaults = [
        ['key'=>'job','name'=>'Boost JOB','role'=>'採用運用代行','color'=>'var(--c-job)',
         'catch'=>"その採用費、<br>無駄になっていませんか？",
         'body'=>"求人掲載だけでは終わらない。採用戦略から応募獲得、改善まで一貫して支援します。",
         'feats'=>["求人原稿制作","求人媒体運用","応募通知","改善分析"]],
        ['key'=>'site','name'=>'Boost SITE','role'=>'ホームページ制作','color'=>'var(--c-site)',
         'catch'=>'そのサイト、<br>"使える状態"ですか？',
         'body'=>'"あるだけ"のホームページから、成果を生み出すホームページへ。企業の信頼感、採用力、問い合わせ獲得まで見据えて制作します。',
         'feats'=>["オリジナルデザイン","コーポレートサイト","採用サイト","LP制作","SEO","運用保守"]],
        ['key'=>'media','name'=>'Boost MEDIA','role'=>'SNS運用代行','color'=>'var(--c-media)',
         'catch'=>'"やっているだけ"<br>になっていませんか？',
         'body'=>"企画・撮影・編集・投稿・分析まで。企業の魅力をSNSで届け、認知と信頼につなげます。",
         'feats'=>["Instagram","TikTok","撮影","投稿制作","リール編集","分析レポート"]],
        ['key'=>'film','name'=>'Boost FILM','role'=>'AI動画制作','color'=>'var(--c-film)',
         'catch'=>"伝わる動画は、<br>営業マンより働く。",
         'body'=>"採用、PR、広告、SNSショート動画まで。AIを活用し、スピードとクオリティを両立した動画制作を提供します。",
         'feats'=>["採用動画","企業PR動画","広告動画","ショート動画","AI動画"]],
        ['key'=>'gbp','name'=>'Boost GBP','role'=>'Googleビジネスプロフィール運用','color'=>'var(--c-gbp)',
         'catch'=>"地域で、<br>選ばれる会社へ。",
         'body'=>"Google検索・Googleマップで見つけられ、選ばれる状態を作ります。口コミ、投稿、分析、改善まで運用支援します。",
         'feats'=>["Googleマップ対策","MEO対策","口コミ運用","投稿管理","分析改善"]],
        ['key'=>'ai','name'=>'Boost AI','role'=>'AI導入・業務効率化','color'=>'var(--c-ai)',
         'catch'=>"AIを、<br>成果につながる力へ。",
         'body'=>"ChatGPT、Claude、AIツールを活用し、業務効率化・営業支援・制作支援・社内DXをサポートします。",
         'feats'=>["ChatGPT活用","Claude活用","AI活用研修","業務効率化","DX支援","AI動画/画像活用"]],
    ];

    // ACFオプションのリピーター「services」があれば上書き
    if (function_exists('have_rows') && have_rows('services', 'option')) {
        $out = [];
        $map = ['job'=>'var(--c-job)','site'=>'var(--c-site)','media'=>'var(--c-media)','film'=>'var(--c-film)','gbp'=>'var(--c-gbp)','ai'=>'var(--c-ai)'];
        while (have_rows('services', 'option')) {
            the_row();
            $key = get_sub_field('key');
            $feats_raw = get_sub_field('feats');
            $feats = is_array($feats_raw) ? array_map(fn($r) => is_array($r) ? ($r['feat'] ?? '') : $r, $feats_raw)
                                          : array_filter(array_map('trim', explode("\n", (string)$feats_raw)));
            $out[] = [
                'key'   => $key,
                'name'  => get_sub_field('name'),
                'role'  => get_sub_field('role'),
                'color' => $map[$key] ?? 'var(--blue)',
                'catch' => nl2br(get_sub_field('catch')),
                'body'  => get_sub_field('body'),
                'feats' => array_values(array_filter($feats)),
            ];
        }
        if ($out) return $out;
    }
    return $defaults;
}

/* ---------- サービスキー → カラー / ラベル ---------- */
function bdot_svc_color($k) {
    return ['job'=>'var(--c-job)','site'=>'var(--c-site)','media'=>'var(--c-media)','film'=>'var(--c-film)','gbp'=>'var(--c-gbp)','ai'=>'var(--c-ai)'][$k] ?? 'var(--blue)';
}
function bdot_svc_label($k) {
    return ['job'=>'Boost JOB','site'=>'Boost SITE','media'=>'Boost MEDIA','film'=>'Boost FILM','gbp'=>'Boost GBP','ai'=>'Boost AI'][$k] ?? $k;
}

/* ---------- OGP（基本） ---------- */
add_action('wp_head', function () {
    $title = wp_get_document_title();
    $desc  = bdot_opt('meta_description', get_bloginfo('description'));
    echo "\n<meta property=\"og:title\" content=\"" . esc_attr($title) . "\" />\n";
    echo "<meta property=\"og:description\" content=\"" . esc_attr($desc) . "\" />\n";
    echo "<meta property=\"og:type\" content=\"website\" />\n";
    echo "<meta name=\"description\" content=\"" . esc_attr($desc) . "\" />\n";
}, 5);

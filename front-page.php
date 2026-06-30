<?php
/**
 * front-page.php — LP本体
 */
if (!defined('ABSPATH')) exit;
get_header();

$services = bdot_get_services();
?>

<!-- HERO -->
<header class="hero" id="top">
  <div class="hero-bg">
    <?php if ($v = bdot_opt('hero_video')): ?>
      <video class="hero-video" autoplay muted loop playsinline style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.5">
        <source src="<?php echo esc_url($v); ?>" type="video/mp4">
      </video>
    <?php endif; ?>
    <div class="aurora a1" data-par="0.18"></div>
    <div class="aurora a2" data-par="-0.12"></div>
    <div class="aurora a3" data-par="0.08"></div>
    <div class="grid-fade"></div>
  </div>
  <div class="floaters" id="floaters" aria-hidden="true"></div>
  <div class="hero-veil"></div>

  <div class="hero-inner">
    <?php
    $hero_title = bdot_opt('hero_title', "企業の成長に必要な\nサービスを、\nワンストップで。");
    $lines = preg_split('/\r\n|\r|\n/', trim($hero_title));
    echo '<h1 id="heroH1">';
    foreach ($lines as $i => $ln) {
        $last = ($i === count($lines) - 1);
        echo '<span class="ln"><span>' . esc_html(rtrim($ln, '。')) . ($last ? '<i class="dot">.</i>' : (mb_substr($ln, -1) === '。' ? '。' : '')) . '</span></span>';
    }
    echo '</h1>';
    ?>
    <p class="hero-sub reveal" data-d="2">
      <?php echo nl2br(esc_html(bdot_opt('hero_sub', "採用・Web制作・SNS運用・AI動画・MEO・AI活用まで。\n中小企業の課題を、成果につながる仕組みで解決します。"))); ?>
    </p>
    <div class="hero-cta reveal" data-d="3">
      <a href="<?php echo esc_url(bdot_opt('cta_url', '#cta')); ?>" class="btn btn-primary mag">無料相談する<span class="arr">→</span></a>
      <a href="#services" class="btn btn-ghost mag">サービスを見る</a>
    </div>
  </div>
  <div class="scroll-cue"><span>Scroll</span><span class="rail"></span></div>
</header>

<!-- ABOUT -->
<section class="sec about" id="about">
  <div class="wrap about-grid">
    <div>
      <span class="eyebrow reveal">About</span>
      <h2 class="reveal" data-d="1" style="margin-top:22px">
        <?php echo nl2br(esc_html(bdot_opt('about_title', "一つのサービスを売るのではなく、\n課題に合わせて最適な仕組みを"))); ?><i class="dot">.</i>
      </h2>
    </div>
    <p class="reveal" data-d="2"><?php echo esc_html(bdot_opt('about_body', '企業ごとに課題は異なります。採用、集客、ブランディング、AI活用。B.は企業の成長フェーズに合わせて、必要なサービスを組み合わせてご提案します。')); ?></p>
  </div>
</section>

<!-- SERVICES（switcherはJSが B_DATA.services から構築） -->
<section class="services" id="services">
  <div class="sv-stage" id="svStage">
    <div class="sv-glow" id="svGlow"></div>
    <div class="sv-inner">
      <div class="sv-rail" id="svRail" role="tablist"></div>
      <div class="sv-panels" id="svPanels"></div>
    </div>
  </div>
</section>

<!-- ACHIEVEMENTS -->
<section class="sec ach" id="ach">
  <div class="wrap">
    <span class="eyebrow reveal" style="justify-content:center;display:flex">Achievements</span>
    <h2 class="sec-title reveal" data-d="1" style="text-align:center;margin-top:22px">数字で見るB<i class="dot">.</i></h2>
    <div class="ach-grid">
      <div class="ach-card reveal" data-d="1"><div class="ach-num"><span class="cnt" data-to="<?php echo (int)bdot_opt('ach_companies', 200); ?>">0</span><span class="suf">社+</span></div><div class="ach-label">導入企業数</div></div>
      <div class="ach-card reveal" data-d="2"><div class="ach-num"><span class="cnt" data-to="<?php echo (int)bdot_opt('ach_services', 250); ?>">0</span><span class="suf">件+</span></div><div class="ach-label">導入サービス数</div></div>
      <div class="ach-card reveal" data-d="3"><div class="ach-num"><span class="cnt" data-to="<?php echo (int)bdot_opt('ach_retention', 95); ?>">0</span><span class="suf">%+</span></div><div class="ach-label">継続率</div></div>
    </div>
  </div>
</section>

<!-- CASES（CPT: b_case） -->
<section class="sec cases" id="cases">
  <div class="wrap">
    <div class="sec-head">
      <span class="eyebrow reveal">Cases</span>
      <h2 class="sec-title reveal" data-d="1" style="margin-top:20px">導入実績<span class="sm">業種・地域・課題の異なる企業を、それぞれの最適解で。</span></h2>
    </div>
    <div class="cases-filter reveal" data-d="1" id="caseFilter"></div>
    <div class="cases-grid" id="caseGrid">
      <?php
      $cases = new WP_Query([
        'post_type' => 'b_case', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC',
        'meta_query' => [['key' => 'visible', 'value' => '1', 'compare' => '=']],
      ]);
      if ($cases->have_posts()):
        while ($cases->have_posts()): $cases->the_post();
          $svcs = (array) get_field('services');
          $svc  = $svcs[0] ?? 'site';
          $company = get_field('company') ?: get_the_title();
          $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: (get_field('logo') ?: '');
      ?>
        <article class="case-card reveal"
          style="--cc:<?php echo esc_attr(bdot_svc_color($svc)); ?>"
          data-svc="<?php echo esc_attr($svc); ?>"
          data-company="<?php echo esc_attr($company); ?>"
          data-ind="<?php echo esc_attr(get_field('industry')); ?>"
          data-area="<?php echo esc_attr(get_field('area')); ?>"
          data-res="<?php echo esc_attr(get_field('result')); ?>"
          data-desc="<?php echo esc_attr(get_field('intro')); ?>"
          data-url="<?php echo esc_attr(get_field('url')); ?>"
          data-label="<?php echo esc_attr(bdot_svc_label($svc)); ?>"
          data-thumb="<?php echo esc_attr($thumb); ?>">
          <div class="case-thumb">
            <?php if ($thumb): ?><img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($company); ?>" loading="lazy"><?php endif; ?>
            <div class="ph"><?php echo esc_html(mb_substr($company, 0, 1)); ?></div>
          </div>
          <span class="case-svc"><i></i><?php echo esc_html(bdot_svc_label($svc)); ?></span>
          <div class="case-meta">
            <div class="ind"><?php echo esc_html(get_field('industry')); ?>・<?php echo esc_html(get_field('area')); ?></div>
            <h3><?php echo esc_html($company); ?></h3>
            <div class="res">▲ <?php echo esc_html(get_field('result')); ?></div>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); else: ?>
        <p style="color:var(--paper-dim)">導入実績は「導入実績」メニューから追加してください。</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- VOICE（CPT: b_voice） -->
<section class="sec voice" id="voice">
  <div class="wrap">
    <div class="sec-head" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:20px">
      <div>
        <span class="eyebrow reveal">Customer Voice</span>
        <h2 class="sec-title reveal" data-d="1" style="margin-top:20px">お客様の声</h2>
      </div>
      <div class="voice-nav reveal" data-d="2"><button id="vPrev" aria-label="前へ">←</button><button id="vNext" aria-label="次へ">→</button></div>
    </div>
  </div>
  <div class="wrap">
    <div class="voice-track" id="voiceTrack">
      <?php
      $voices = new WP_Query([
        'post_type' => 'b_voice', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC',
        'meta_query' => [['key' => 'visible', 'value' => '1', 'compare' => '=']],
      ]);
      if ($voices->have_posts()):
        while ($voices->have_posts()): $voices->the_post();
          $rating = (int) (get_field('rating') ?: 5);
          $svc = get_field('service') ?: 'site';
          $person = get_field('person') ?: get_the_title();
          $photo = get_field('photo') ?: get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
      ?>
        <div class="voice-card">
          <div class="voice-stars"><?php echo str_repeat('★', $rating) . str_repeat('☆', 5 - $rating); ?></div>
          <p><?php echo esc_html(get_field('comment')); ?></p>
          <div class="voice-person">
            <?php if ($photo): ?>
              <div class="voice-ava" style="background-image:url('<?php echo esc_url($photo); ?>');background-size:cover"></div>
            <?php else: ?>
              <div class="voice-ava"><?php echo esc_html(mb_substr($person, 0, 1)); ?></div>
            <?php endif; ?>
            <div>
              <div class="nm"><?php echo esc_html($person); ?></div>
              <div class="ti"><?php echo esc_html(get_field('role')); ?>／<?php echo esc_html(get_field('company')); ?></div>
              <div class="voice-tag" style="--svc:<?php echo esc_attr(bdot_svc_color($svc)); ?>"><?php echo esc_html(bdot_svc_label($svc)); ?></div>
            </div>
          </div>
        </div>
      <?php endwhile; wp_reset_postdata(); else: ?>
        <p style="color:var(--paper-dim)">お客様の声は「お客様の声」メニューから追加してください。</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- WHY -->
<section class="sec why" id="why">
  <div class="wrap">
    <span class="eyebrow reveal">Why B.</span>
    <div class="why-grid">
      <div>
        <h2 class="sec-title reveal" data-d="1" style="margin:18px 0 26px">企業ごとに課題は違う。<br>だから提案も違う<i class="dot">.</i></h2>
        <p class="why-lead reveal" data-d="2">B.は、決まったサービスを売る会社ではありません。企業ごとの課題を整理し、必要な施策を組み合わせて、成果につながる仕組みをご提案します。</p>
      </div>
      <div class="why-points">
        <div class="why-pt reveal"><span class="n">01</span><p>採用から集客まで、一社で対応</p></div>
        <div class="why-pt reveal" data-d="1"><span class="n">02</span><p>制作だけでなく、運用まで支援</p></div>
        <div class="why-pt reveal" data-d="2"><span class="n">03</span><p>SNS・Web・AIを横断した提案</p></div>
        <div class="why-pt reveal" data-d="3"><span class="n">04</span><p>中小企業に寄り添ったスピード感</p></div>
      </div>
    </div>
  </div>
</section>

<!-- FLOW -->
<section class="sec flow" id="flow">
  <div class="wrap">
    <div class="sec-head"><span class="eyebrow reveal">Flow</span><h2 class="sec-title reveal" data-d="1" style="margin-top:20px">導入までの流れ</h2></div>
    <div class="flow-list" id="flowList">
      <?php
      $flow = [
        ['01','無料相談','まずは現状と課題をお気軽にお聞かせください。'],
        ['02','ヒアリング','事業・体制・目標を深く理解します。'],
        ['03','ご提案','課題に合わせて最適な施策を設計します。'],
        ['04','制作・運用開始','スピード感を持って実行に移します。'],
        ['05','改善・伴走','数値を見ながら継続的に改善します。'],
      ];
      foreach ($flow as $f): ?>
        <div class="flow-row"><span class="fn"><?php echo esc_html($f[0]); ?></span><span class="ft"><?php echo esc_html($f[1]); ?></span><span class="fd"><?php echo esc_html($f[2]); ?></span></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="sec cta" id="cta">
  <div class="wrap cta-inner">
    <h2 class="reveal"><?php echo nl2br(esc_html(bdot_opt('cta_title', "まずはお気軽に\nご相談ください"))); ?><i class="dot">.</i></h2>
    <p class="reveal" data-d="1"><?php echo esc_html(bdot_opt('cta_body', '採用、Web、SNS、動画、MEO、AI活用まで。企業ごとの課題をヒアリングし、最適なサービスをご提案します。')); ?></p>
    <a href="<?php echo esc_url(bdot_opt('cta_url', '#')); ?>" class="btn btn-primary mag reveal" data-d="2" style="font-size:1.05rem;padding:18px 38px">無料相談はこちら<span class="arr">→</span></a>
  </div>
</section>

<?php get_footer(); ?>

<?php
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main class="wrap" style="padding:160px 0 100px">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <article style="margin-bottom:60px">
      <h1 class="sec-title"><?php the_title(); ?></h1>
      <div style="color:var(--paper-dim);margin-top:20px"><?php the_content(); ?></div>
    </article>
  <?php endwhile; else: ?>
    <p>コンテンツがありません。</p>
  <?php endif; ?>
</main>
<?php get_footer(); ?>

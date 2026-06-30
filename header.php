<?php if (!defined('ABSPATH')) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav class="nav" id="nav">
  <a href="<?php echo esc_url(home_url('/')); ?>#top" class="brand">B<i class="dot">.</i></a>
  <div class="nav-links" id="navlinks">
    <a href="#about">About</a>
    <a href="#services">Services</a>
    <a href="#cases">実績</a>
    <a href="#voice">お客様の声</a>
    <a href="#flow">Flow</a>
    <a href="<?php echo esc_url(bdot_opt('cta_url', '#cta')); ?>" class="nav-cta">無料相談する</a>
  </div>
  <button class="nav-toggle" id="navtoggle" aria-label="メニュー"><span></span><span></span><span></span></button>
</nav>

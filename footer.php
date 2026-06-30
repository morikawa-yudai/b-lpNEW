<?php if (!defined('ABSPATH')) exit; ?>

<footer class="footer">
  <div class="wrap">
    <div class="foot-grid">
      <div class="foot-brand">
        <a href="<?php echo esc_url(home_url('/')); ?>#top" class="brand">B<i class="dot">.</i></a>
        <p><?php echo esc_html(bdot_opt('hero_sub', '企業の成長に必要なサービスを、ワンストップで。')); ?></p>
      </div>
      <div class="foot-col">
        <h4>Services</h4>
        <?php foreach (bdot_get_services() as $s): ?>
          <a href="#services"><?php echo esc_html($s['name']); ?></a>
        <?php endforeach; ?>
      </div>
      <div class="foot-col">
        <h4>Company</h4>
        <a href="#">会社情報</a>
        <a href="#cases">導入実績</a>
        <a href="<?php echo esc_url(bdot_opt('cta_url', '#cta')); ?>">お問い合わせ</a>
        <a href="<?php echo esc_url(get_privacy_policy_url() ?: '#'); ?>">プライバシーポリシー</a>
      </div>
      <div class="foot-col">
        <h4>Follow</h4>
        <a href="#">Instagram</a><a href="#">TikTok</a><a href="#">X / Twitter</a><a href="#">YouTube</a>
      </div>
    </div>
    <div class="foot-bottom">
      <span>© <?php echo date('Y'); ?> 株式会社B. All rights reserved.</span>
      <div class="sns"><a href="<?php echo esc_url(get_privacy_policy_url() ?: '#'); ?>">Privacy</a><a href="#">Terms</a></div>
    </div>
  </div>
</footer>

<!-- 実績モーダル -->
<div class="modal" id="modal">
  <div class="modal-bd" id="modalBd"></div>
  <div class="modal-card" id="modalCard">
    <button class="modal-x" id="modalX" aria-label="閉じる">✕</button>
    <div class="modal-thumb" id="mThumb"></div>
    <div class="modal-body">
      <div class="modal-svc" id="mSvc"><i></i><span></span></div>
      <div class="ind" id="mInd"></div>
      <h3 id="mName"></h3>
      <p id="mDesc"></p>
      <div class="modal-res" id="mRes"></div>
      <a class="modal-link" id="mLink" href="#" target="_blank" rel="noopener" style="display:none">ホームページを見る →</a>
    </div>
  </div>
</div>

<?php wp_footer(); ?>
</body>
</html>

# B. Service LP — WordPress オリジナルテーマ

株式会社B. のサービス一覧LP。HERO／ABOUT／SERVICES（スクロール切替）／実績数値カウントアップ／導入実績CMS／お客様の声CMS／WHY／FLOW／CTA／FOOTER。

## 構成
```
b-dot/
├─ style.css            … テーマヘッダー
├─ functions.php        … セットアップ・アセット読込・サービス定義・OGP
├─ front-page.php       … LP本体（固定フロントページに適用）
├─ index.php            … フォールバック
├─ header.php / footer.php
├─ inc/
│  ├─ cpt.php           … カスタム投稿タイプ（導入実績 b_case / お客様の声 b_voice）
│  └─ acf-fields.php    … ACFフィールドをコード登録（手動作成不要）
└─ assets/
   ├─ css/main.css      … スタイル一式（GSAP演出前提）
   └─ js/main.js        … GSAP/ScrollTrigger・モーダル・カルーセル・カウンター
```

## セットアップ
1. `b-dot` フォルダを `wp-content/themes/` に置き、管理画面 → 外観 → テーマで有効化。
2. プラグイン **Advanced Custom Fields（ACF）** を導入・有効化（無料版でOK。リピーター等を使う場合はPRO推奨）。
   - フィールドはコード登録済みのため、管理画面での手動作成は不要です。
3. 固定ページ「ホーム」を新規作成 → 設定 → 表示設定 → ホームページの表示を「固定ページ」にして「ホーム」を指定。
   - `front-page.php` が自動で使われます。
4. メニュー「**B. サイト設定**」でHERO・ABOUT・実績数値・CTA・SEO・サービス内容を編集。
5. 「**導入実績**」「**お客様の声**」から投稿を追加（各項目はACFで入力、表示/非表示トグルあり）。
6. パーマリンク設定を一度「変更を保存」して、CPTのスラッグを反映。

## 編集できる項目（管理画面）
- HERO：メインコピー／サブコピー／背景動画(mp4)
- ABOUT：見出し／本文
- 実績数値：導入企業数／導入サービス数／継続率（カウントアップ）
- CTA：見出し／本文／お問い合わせURL／meta description
- サービス：6種の名称・キャッチ・本文・特徴（リピーター）
- 導入実績(CPT)：ロゴ・企業名・業種・地域・導入サービス・サムネ・紹介文・成果・URL・導入年月・表示
- お客様の声(CPT)：会社名・氏名・役職・顔写真・利用サービス・コメント・星評価・表示

## まだ本番化に必要なもの（任意）
- お問い合わせフォーム：Contact Form 7 / Snow Monkey Forms 等を `#cta` 付近に設置（テーマ側は導線のみ）。
- 画像/動画最適化：WebP化・遅延読込（実装済の loading="lazy"）・動画は圧縮。
- 絞り込み強化：現状はサービス別フィルタ。業種・地域での絞り込みは `tax_query` 化 or JSフィルタ拡張で対応可。
- GitHub/Vercel：テーマを Git 管理し、プレビューはローカル（Local / wp-env）や Headless 運用を想定。

## デザイントークン
- Ink #0A0B0D / Paper #FAFAFA / B.Blue #2F6BFF
- JOB #16C8C8 / SITE #FF7A1A / MEDIA #9B5CFF / FILM #FF3D54 / GBP #2BA8FF / AI #27D17C
- 和文 Zen Kaku Gothic New ／ 欧文 Space Grotesk
- シグネチャー：ブランドの「.（ピリオド）」がスクロールに応じて各サービスカラーへ変化

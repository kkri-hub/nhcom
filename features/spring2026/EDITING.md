# 編集ガイド

このリポジトリは **docs直編集型** で運用します。ビルドプロセスは不要です。

## 📂 編集対象ファイル

```
docs/
├── index.html          # LP本体（HTMLを直接編集）
├── css/
│   └── style.css      # スタイル（デザイン変更）
└── images/            # 画像ファイル
    ├── hero.jpg       # ヒーロー画像
    ├── grad.jpg       # 卒業シーン
    ├── new.jpg        # 入学シーン
    └── prom.jpg       # 昇進シーン
```

## ✏️ 編集フロー（3ステップ）

### 1. ローカルでプレビュー

```bash
# docs/ディレクトリをローカルサーバーで確認
python3 -m http.server 8000 -d docs
```

ブラウザで `http://localhost:8000` を開く

### 2. ファイルを編集

- テキスト変更 → `docs/index.html`
- デザイン変更 → `docs/css/style.css`
- 画像差し替え → `docs/images/` に上書き保存

### 3. プッシュして公開

```bash
git add docs/
git commit -m "update: LP content"
git push origin main
```

数分後、GitHub Pagesに自動反映されます。

## ⚡ ショートカット設定（推奨）

`.zshrc` または `.bashrc` に追加：

```bash
# LP更新用エイリアス
alias lp-preview='python3 -m http.server 8000 -d docs'
alias lp-push='git add docs/ && git commit -m "update: LP $(date +%Y-%m-%d)" && git push origin main'
```

**使用例:**
```bash
lp-preview   # プレビュー起動
lp-push      # 編集後、即座に公開
```

## 🚫 触ってはいけないもの

- `README.md` → プロジェクト概要（開発者向け）
- `.git/` → Git管理ディレクトリ
- `.gitignore` → 除外設定

## 📝 よくある編集

### テキスト変更

`docs/index.html` の該当箇所を直接編集：

```html
<!-- 例: ヒーローのサブタイトル変更 -->
<p class="subtitle">大切な方への春の贈りもの。心を込めて、想いをかたちに。</p>
```

### 色の変更

`docs/css/style.css` のCSS変数を編集：

```css
:root {
  --gold: #c5a059;        /* ゴールドのメインカラー */
  --text: #2a2a2a;        /* テキスト色 */
  --bg: #fbfaf8;          /* 背景色 */
}
```

### 画像の差し替え

1. `docs/images/` に同名ファイルで上書き
2. または、新しいファイル名で保存 → `index.html` のパスを変更

```html
<!-- 例: ヒーロー画像を変更 -->
<div class="hub-hero" style="background-image: url('images/new-hero.jpg')">
```

### リンク先の変更

外部リンク（nakatahanger.com）の変更：

```html
<!-- 例: ボタンのリンク先変更 -->
<a href="https://www.example.com/new-link" target="_blank" rel="noopener" class="btn-outline">
  ギフトを見る
</a>
```

## 🌍 将来の多言語化について

現在は日本語のみ。将来、英語版を追加する場合：

```
docs/
├── index.html          # 言語検出 → リダイレクト
├── ja/                 # 日本語版
│   └── index.html
└── en/                 # 英語版
    └── index.html
```

詳細は開発者に相談してください。

## 🆘 トラブルシューティング

### プレビューが表示されない

```bash
# ポートを変更して再試行
python3 -m http.server 3000 -d docs
```

### プッシュできない

```bash
# 最新の変更を取得してから再プッシュ
git pull origin main
git push origin main
```

### 変更が反映されない

1. GitHub リポジトリで最新コミットを確認
2. Actions タブでデプロイ状態を確認
3. 5-10分待ってからリロード
4. ブラウザのキャッシュをクリア（Cmd+Shift+R / Ctrl+Shift+R）

---

**更新日**: 2026-02-13

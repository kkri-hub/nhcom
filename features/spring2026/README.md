# lp-vite

Viteをベースにした高速なランディングページプロジェクト。GitHub Pagesで自動公開されます。

<!-- デモサイトのURLがある場合は以下のコメントを外して追加 -->
<!-- 🔗 **[デモサイト](https://your-username.github.io/lp-vite/)** -->

## ✨ 特徴

- ⚡ Viteによる高速な開発体験
- 📦 シンプルなビルド設定（`docs/` に出力）
- 🚀 GitHub Pagesで自動デプロイ
- 🔧 直接編集も可能（`docs/` を手動編集 → push で即反映）

## 🛠 技術スタック

- **ビルドツール**: Vite
- **デプロイ**: GitHub Pages
- **出力先**: `docs/` ディレクトリ

## 📁 プロジェクト構成

```
lp-vite/
├── src/          # ソースファイル（開発用）
├── docs/         # ビルド出力（GitHub Pages公開用）
├── public/       # 静的アセット
├── vite.config.js
└── package.json
```

## 🚀 セットアップ

### 初回セットアップ

```bash
# リポジトリをクローン
git clone <repository-url>
cd lp-vite

# 依存関係をインストール
npm install
```

### 開発サーバーの起動

```bash
npm run dev
```

ブラウザで `http://localhost:5173` を開いて開発を始められます。

## 📝 更新フロー

### 方法1: 通常の開発フロー（推奨）

1. **ローカルで編集・開発**
   ```bash
   npm run dev
   ```
   `src/` 内のファイルを編集して動作確認

2. **ビルド** （src/ → docs/）
   ```bash
   npm run build
   ```

3. **変更をコミット & プッシュ**
   ```bash
   git add .
   git commit -m "update: 変更内容の説明"
   git push origin main
   ```

4. **自動デプロイ**
   GitHub Actions が自動的に `docs/` を GitHub Pages に公開

### 方法2: 直接編集（簡易更新）

```bash
# docs/ 内のファイルを直接編集
vim docs/index.html

# プッシュすれば即反映
git add docs/
git commit -m "docs: 直接編集"
git push origin main
```

## 📋 コマンド一覧

| コマンド | 説明 |
|---------|------|
| `npm install` | 依存関係のインストール |
| `npm run dev` | 開発サーバー起動（ホットリロード有効） |
| `npm run build` | プロダクションビルド（`src/` → `docs/`） |
| `npm run preview` | ビルド結果をローカルでプレビュー |

## ⚙️ GitHub Pages 設定

リポジトリの設定を確認してください：

1. **Settings** → **Pages**
2. **Source**: `main` ブランチの `/docs` フォルダを指定
3. 保存後、数分でサイトが公開されます

## 🔧 トラブルシューティング

### ビルドエラーが出る場合

```bash
# node_modules を削除して再インストール
rm -rf node_modules package-lock.json
npm install
```

### GitHub Pages に反映されない場合

- `docs/` ディレクトリがコミットされているか確認
- GitHub リポジトリの Settings → Pages で設定を確認
- Actions タブでデプロイステータスを確認

### ローカル開発サーバーが起動しない場合

```bash
# ポートが使用中の可能性があります
npm run dev -- --port 3000
```

## 📄 ライセンス

このプロジェクトのライセンスについては、リポジトリのオーナーにお問い合わせください。

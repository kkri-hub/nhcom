# NAKATA HANGER — LP管理リポジトリ

## 概要

NAKATA HANGER のLP・バナー・コンテンツをGitで管理するリポジトリです。

- **本番サイト:** https://www.nakatahanger.com/
- **デプロイ方法:** FileZillaでFTPアップロード（GitはコードのバックアップとGit管理のみ）

---

## フォルダ構成

```
nhcom/
├── index.html          # LP一覧（ブラウザで直接開いて確認）
├── index.php           # 本番ホームページのバックアップ
├── banner-preview.php  # バナープレビューページ（ローカル確認用）
├── include/            # PHPフレームワーク一式
│   ├── nh.php          # メインフレームワーク
│   ├── update.php      # ★バナー・コンテンツ管理ファイル（ここを編集）
│   └── update/         # 各種動的コンテンツ
└── features/
    ├── set01gy/        # SET-01 LP
    ├── spring2026/     # 春2026 LP
    └── fathersday/     # 父の日 LP
```

---

## ブランチ運用

| ブランチ | 用途 |
|----------|------|
| `main` | 本番 |
| `develop` | 開発・確認用 |

---

## ローカル環境のセットアップ

### PHPインストール（初回のみ）

```bash
sudo apt-get install -y php
```

### PHPサーバー起動

```bash
cd ~/nhcom
php -S localhost:8000
```

---

## バナー管理の方法

### 1. バナーのON/OFF切り替え

`include/update.php` を開いて `true` / `false` を変更する。

```php
// 例：輪島塗バナーを非表示にする
define("SHOW_HEADER_NEWS_2", false); // true → false

// 例：アウトレットバナーを表示する
define("SHOW_HEADER_NEWS_1", true);  // false → true
```

### 2. ローカルでプレビュー確認

PHPサーバーを起動した状態でブラウザを開く：

```
http://localhost:8000/banner-preview.php
```

各バナーの **表示中 / 非表示** と画像が確認できます。

### 3. Gitにコミット

```bash
git add include/update.php
git commit -m "fix: ヘッダーバナーを〇〇に変更"
```

### 4. 本番に反映

FileZillaで `include/update.php` を本番サーバーにアップロードする。

---

## LP一覧ページの確認

| LP | ローカル確認URL |
|----|---------------|
| SET-01 GY | http://localhost:8000/features/set01gy/ |
| SPRING 2026 | http://localhost:8000/features/spring2026/ |
| 父の日 | http://localhost:8000/features/fathersday/ |

---

## 新しいLPを追加する場合

1. `develop` ブランチで作業
2. `features/` 以下に新しいフォルダを作成
3. 確認後、`main` にマージ

---

## セキュリティ注意事項

`include/const-before-text.php` には **Shopify APIキー・CMS Token・reCAPTCHAキー** が含まれるため `.gitignore` で除外しています。

このファイルは **Gitにコミットしない** でください。

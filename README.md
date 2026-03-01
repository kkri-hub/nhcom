# nhcom

NAKATA HANGER LP 管理リポジトリ

## 構成

```
nhcom/
├── features/
│   ├── set01gy/       # SET 01 GY LP（静的HTML）
│   └── spring2026/    # SPRING 2026 LP（Vite / docs/に出力）
└── index.html          # LP一覧ページ
```

## ブランチ運用

| ブランチ | 用途 |
|----------|------|
| `main` | 本番 |
| `develop` | 開発・確認用 |

## 新しいLPを追加する場合

1. `develop` ブランチで作業
2. `features/` 以下に新しいフォルダを作成
3. 確認後、`main` にマージ

(function () {
  'use strict';

  // ============================================================
  // NAKATA HANGER Chatbot
  // 埋め込み方法: <script src="nakata-chatbot.js"></script>
  // ============================================================

  const COLORS = {
    bg: '#F6F4EF',
    subBg: '#FFFFFF',
    text: '#2E2E2E',
    subText: '#999999',
    accent: '#4B3621',
    border: 'rgba(75,54,33,0.15)',
    userBubble: '#4B3621',
    userText: '#F6F4EF',
    botBubble: '#FFFFFF',
  };

  // ------------------------------------------------------------
  // FAQ データ
  // ------------------------------------------------------------
  const FAQ = [
    // ── 素材・品質 ──────────────────────────────────────────────
    {
      keywords: ['材料', '素材', '木', 'ブナ', '材質', 'material', '天然'],
      question: '木製ハンガーの材料は何ですか？',
      answer: 'ヨーロッパ産のブナ材を使用しています。硬く均質で節が少なく、ハンガーに最適な材料です。環境保護のため、計画的に伐採された天然木のみを使用しています。',
    },
    {
      keywords: ['一本物', '高い', '価格', '値段', '高価', '理由', '職人', '削り出し'],
      question: '一本物ハンガーが高価な理由は？',
      answer: '厳選した厚板から熟練職人がフリーハンドで削り出した逸品です。繋ぎ目がなく、襟元の重厚なラインと滑らかな曲線を実現するため、高度な技術と多くの時間を要します。',
    },
    // ── サイズ選び ──────────────────────────────────────────────
    {
      keywords: ['サイズ', '寸法', '幅', '肩幅', 'サイズ感', 'mm', '合う', '選び方', '測り方', 'どれ'],
      question: 'ハンガーのサイズはどう選べばよいですか？',
      answer: '【幅】は服の肩幅、【厚み】は服の種類で選びます。\n\n▼ 測り方\n服を平置きにして背面の肩縫い目の間を直線で計測し、以下を引いた数値が目安です。\n・ジャケット：20〜40mm引く\n・シャツ／ブラウス：10〜20mm引く\n\n▼ 展開サイズ\n360 / 380 / 400 / 420〜430 / 460mm\nレディース：SS〜S・M　メンズ：S・M・L',
      link: { text: 'サイズの選び方ガイド', url: 'https://www.nakatahanger.com/howto/' },
    },
    // ── 種類・ラインナップ ───────────────────────────────────────
    {
      keywords: ['種類', 'ラインナップ', '何がある', '商品', 'ジャケット', 'シャツ', 'ボトム', 'スカート', 'コート'],
      question: 'どんな種類のハンガーがありますか？',
      answer: '用途別に豊富なラインナップがあります。\n\n▼ メンズ\nジャケット用 / シャツ用 / ボトム用\n\n▼ レディース\nジャケット用 / シャツ用 / ボトム用\n\n▼ 小物・その他\nストール・ベルト用 / ネクタイ用 / キッズ / ペット / 和装 / メンテナンス用品（ブラシ・靴べら・ラック）',
      link: { text: '商品一覧を見る', url: 'https://www.nakatahanger-shop.com/' },
    },
    {
      keywords: ['キッズ', '子供', '子ども', 'こども', '子ども用'],
      question: '子ども用ハンガーはありますか？',
      answer: 'はい、キッズハンガーもご用意しています。ショップよりご確認ください。',
      link: { text: 'ショップで確認', url: 'https://www.nakatahanger-shop.com/' },
    },
    {
      keywords: ['ペット', '犬', '猫', 'ペット用'],
      question: 'ペット用ハンガーはありますか？',
      answer: 'はい、ペット用ハンガーもご用意しています。ショップよりご確認ください。',
      link: { text: 'ショップで確認', url: 'https://www.nakatahanger-shop.com/' },
    },
    {
      keywords: ['和装', '着物', '浴衣', '和服'],
      question: '和装用ハンガーはありますか？',
      answer: 'はい、和装ハンガーもご用意しています。着物・浴衣の収納にご活用ください。',
      link: { text: 'ショップで確認', url: 'https://www.nakatahanger-shop.com/' },
    },
    // ── カラー ───────────────────────────────────────────────────
    {
      keywords: ['色', 'カラー', 'ナチュラル', 'ブラウン', 'ワインレッド', 'チョコレート', '色味', '色展開'],
      question: 'カラーラインナップを教えてください',
      answer: '以下のカラーをご用意しています。\n\nナチュラル / アーモンド / ワインレッド / マーズブラウン / スモークブラウン / チョコレート\n\n色によって在庫状況が異なります。詳細はショップでご確認ください。',
      link: { text: 'ショップで色を確認', url: 'https://www.nakatahanger-shop.com/' },
    },
    // ── 使い方・ケア ─────────────────────────────────────────────
    {
      keywords: ['フック', '回転', '向き', '方向', 'hook'],
      question: 'フックは回転しますか？',
      answer: 'はい、手で好みの方向に回して固定できます。ネジのように抜けないため、クローゼットの向きに合わせて調整できます（一部商品を除く）。',
    },
    {
      keywords: ['パンツ', 'ズボン', 'スラックス', '吊るし', 'つるし', 'シワ', 'しわ', 'ボトム'],
      question: 'パンツのおすすめの吊るし方は？',
      answer: '裾側を上にして吊るす方法をおすすめしています。ズボン自体の重みでシワ取り効果が期待でき、着用後のシワ伸ばしに適しています。フェルトバー型やクリップ型からお選びいただけます。',
    },
    {
      keywords: ['洗濯', '乾燥', '濡れ', 'ぬれ', '水', '乾かす'],
      question: '洗濯・乾燥用に使えますか？',
      answer: '濡れた衣類は木材劣化や衣類への色移りの原因となるため、収納・ディスプレイ用のみの使用をおすすめしています。乾燥用途にはご使用いただけません。',
    },
    {
      keywords: ['注意', '直射日光', '高温', '多湿', 'クリーニング', '管理', '保管', '保存', 'お手入れ'],
      question: '使用・保管上の注意点は？',
      answer: '以下の点にご注意ください。\n\n・直射日光・高温多湿・火気の近くでの使用は避ける\n・クリーニング直後の衣類は溶剤を十分に揮発させてから掛ける\n\n適切なケアで長くお使いいただけます。',
    },
    // ── カスタム・ギフト ─────────────────────────────────────────
    {
      keywords: ['名入れ', '名前', '刻印', 'レーザー', 'ギフト', 'プレゼント', '贈り物', 'gift', '記念'],
      question: '名入れはできますか？',
      answer: 'はい、レーザー刻印による名入れが可能です。ギフトや記念品として人気です。詳細はお問い合わせください。',
      link: { text: 'お問い合わせはこちら', url: 'https://www.nakatahanger.com/contact/' },
    },
    {
      keywords: ['ロゴ', 'イラスト', 'オリジナル', 'カスタム', 'オーダー'],
      question: 'オリジナルのロゴ・イラストを入れられますか？',
      answer: 'はい、オリジナルのロゴや手書きのイラストを入れることが可能です。詳細はお問い合わせください。',
      link: { text: 'お問い合わせはこちら', url: 'https://www.nakatahanger.com/contact/' },
    },
    // ── 購入・店舗 ──────────────────────────────────────────────
    {
      keywords: ['購入', '買う', '買える', 'ショップ', '注文', 'オンライン', '通販'],
      question: 'どこで購入できますか？',
      answer: 'オンラインショップよりご購入いただけます。',
      link: { text: 'ショップへ', url: 'https://www.nakatahanger-shop.com/' },
    },
    {
      keywords: ['ショールーム', '店舗', '場所', '展示', '見学', '来店', '直接'],
      question: 'ショールームはありますか？',
      answer: 'ショールームの詳細はこちらからご確認いただけます。',
      link: { text: 'ショールーム情報', url: 'https://www.nakatahanger.com/stores/' },
    },
    {
      keywords: ['問い合わせ', '連絡', 'コンタクト', 'メール', '相談', 'contact'],
      question: 'お問い合わせはどうすれば？',
      answer: 'お問い合わせフォームよりお気軽にご連絡ください。',
      link: { text: 'お問い合わせフォーム', url: 'https://www.nakatahanger.com/contact/' },
    },
  ];

  // クイック返信ボタン（最初に表示）
  const QUICK_REPLIES = [
    'サイズの選び方',
    '種類・ラインナップ',
    'カラー展開',
    '名入れ・ギフト',
    'ご購入はこちら',
    'お問い合わせ',
  ];

  const QUICK_REPLY_MAP = {
    'サイズの選び方': 'サイズ',
    '種類・ラインナップ': '種類',
    'カラー展開': 'カラー',
    '名入れ・ギフト': '名入れ',
    'ご購入はこちら': '購入',
    'お問い合わせ': '問い合わせ',
  };

  // ------------------------------------------------------------
  // スタイル
  // ------------------------------------------------------------
  function injectStyles() {
    const style = document.createElement('style');
    style.textContent = `
      #nhcb-btn {
        position: fixed;
        bottom: 28px;
        right: 28px;
        z-index: 9999;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: ${COLORS.accent};
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s, box-shadow 0.2s;
      }
      #nhcb-btn:hover {
        transform: scale(1.08);
        box-shadow: 0 6px 28px rgba(0,0,0,0.5);
      }
      #nhcb-btn svg { display: block; }

      #nhcb-window {
        position: fixed;
        bottom: 96px;
        right: 28px;
        z-index: 9998;
        width: 340px;
        max-width: calc(100vw - 40px);
        height: 500px;
        max-height: calc(100vh - 120px);
        background: ${COLORS.bg};
        border: 1px solid ${COLORS.border};
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 12px 48px rgba(0,0,0,0.5);
        font-family: 'EB Garamond', '游明朝', YuMincho, 'ヒラギノ明朝 ProN W3', 'Hiragino Mincho ProN', serif;
        opacity: 0;
        transform: translateY(16px) scale(0.97);
        pointer-events: none;
        transition: opacity 0.25s, transform 0.25s;
      }
      #nhcb-window.nhcb-open {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: all;
      }

      #nhcb-header {
        padding: 16px 18px;
        background: ${COLORS.subBg};
        border-bottom: 1px solid ${COLORS.border};
        display: flex;
        align-items: center;
        gap: 10px;
      }
      #nhcb-header-logo {
        font-size: 11px;
        letter-spacing: 0.15em;
        color: ${COLORS.accent};
        font-weight: 400;
        text-transform: uppercase;
        flex: 1;
      }
      #nhcb-header-title {
        font-size: 12px;
        color: ${COLORS.subText};
        letter-spacing: 0.05em;
      }
      #nhcb-close {
        background: none;
        border: none;
        cursor: pointer;
        color: ${COLORS.subText};
        padding: 0;
        line-height: 1;
        font-size: 18px;
        transition: color 0.15s;
      }
      #nhcb-close:hover { color: ${COLORS.text}; }

      #nhcb-messages {
        flex: 1;
        overflow-y: auto;
        padding: 16px 14px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        scroll-behavior: smooth;
      }
      #nhcb-messages::-webkit-scrollbar { width: 4px; }
      #nhcb-messages::-webkit-scrollbar-track { background: transparent; }
      #nhcb-messages::-webkit-scrollbar-thumb { background: ${COLORS.border}; border-radius: 2px; }

      .nhcb-msg {
        display: flex;
        flex-direction: column;
        max-width: 88%;
      }
      .nhcb-msg.nhcb-bot { align-self: flex-start; }
      .nhcb-msg.nhcb-user { align-self: flex-end; }

      .nhcb-bubble {
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 13px;
        line-height: 1.7;
        letter-spacing: 0.03em;
        word-break: break-word;
      }
      .nhcb-bot .nhcb-bubble {
        background: ${COLORS.botBubble};
        color: ${COLORS.text};
        border-bottom-left-radius: 4px;
      }
      .nhcb-user .nhcb-bubble {
        background: ${COLORS.userBubble};
        color: ${COLORS.userText};
        border-bottom-right-radius: 4px;
        font-weight: 500;
      }

      .nhcb-link-btn {
        display: inline-block;
        margin-top: 8px;
        padding: 6px 14px;
        border: 1px solid ${COLORS.accent};
        border-radius: 20px;
        color: ${COLORS.accent};
        font-size: 11px;
        letter-spacing: 0.08em;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
        align-self: flex-start;
      }
      .nhcb-link-btn:hover {
        background: ${COLORS.accent};
        color: ${COLORS.bg};
      }

      .nhcb-quick-replies {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
      }
      .nhcb-qr-btn {
        background: none;
        border: 1px solid ${COLORS.border};
        color: ${COLORS.subText};
        font-size: 11px;
        letter-spacing: 0.05em;
        padding: 5px 12px;
        border-radius: 20px;
        cursor: pointer;
        font-family: inherit;
        transition: border-color 0.15s, color 0.15s;
      }
      .nhcb-qr-btn:hover {
        border-color: ${COLORS.accent};
        color: ${COLORS.accent};
      }

      #nhcb-input-area {
        padding: 12px 14px;
        border-top: 1px solid ${COLORS.border};
        display: flex;
        gap: 8px;
        background: ${COLORS.subBg};
      }
      #nhcb-input {
        flex: 1;
        background: ${COLORS.bg};
        border: 1px solid ${COLORS.border};
        border-radius: 8px;
        padding: 8px 12px;
        color: ${COLORS.text};
        font-size: 13px;
        font-family: inherit;
        outline: none;
        transition: border-color 0.15s;
      }
      #nhcb-input::placeholder { color: ${COLORS.subText}; opacity: 0.7; }
      #nhcb-input:focus { border-color: ${COLORS.accent}; }
      #nhcb-send {
        background: ${COLORS.accent};
        border: none;
        border-radius: 8px;
        width: 38px;
        height: 38px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: opacity 0.15s;
      }
      #nhcb-send:hover { opacity: 0.85; }

      @media (max-width: 480px) {
        #nhcb-window {
          right: 12px;
          bottom: 80px;
          width: calc(100vw - 24px);
        }
        #nhcb-btn {
          right: 16px;
          bottom: 20px;
        }
      }
    `;
    document.head.appendChild(style);
  }

  // ------------------------------------------------------------
  // DOM 構築
  // ------------------------------------------------------------
  function buildUI() {
    // トグルボタン
    const btn = document.createElement('button');
    btn.id = 'nhcb-btn';
    btn.setAttribute('aria-label', 'チャットを開く');
    btn.innerHTML = `
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M20 2H4C2.9 2 2 2.9 2 4v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"
          fill="${COLORS.bg}" stroke="${COLORS.bg}" stroke-width="0.5"/>
        <circle cx="8" cy="11" r="1.2" fill="${COLORS.bg}"/>
        <circle cx="12" cy="11" r="1.2" fill="${COLORS.bg}"/>
        <circle cx="16" cy="11" r="1.2" fill="${COLORS.bg}"/>
      </svg>`;

    // チャットウィンドウ
    const win = document.createElement('div');
    win.id = 'nhcb-window';
    win.setAttribute('role', 'dialog');
    win.setAttribute('aria-label', 'NAKATA HANGER チャットサポート');
    win.innerHTML = `
      <div id="nhcb-header">
        <span id="nhcb-header-logo">NAKATA HANGER</span>
        <span id="nhcb-header-title">サポート</span>
        <button id="nhcb-close" aria-label="閉じる">✕</button>
      </div>
      <div id="nhcb-messages"></div>
      <div id="nhcb-input-area">
        <input id="nhcb-input" type="text" placeholder="ご質問をどうぞ…" autocomplete="off" maxlength="200"/>
        <button id="nhcb-send" aria-label="送信">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path d="M2 21l21-9L2 3v7l15 2-15 2v7z" fill="${COLORS.bg}"/>
          </svg>
        </button>
      </div>`;

    document.body.appendChild(btn);
    document.body.appendChild(win);
    return { btn, win };
  }

  // ------------------------------------------------------------
  // メッセージ追加
  // ------------------------------------------------------------
  function addMessage(role, text, linkData, quickReplies, onQR) {
    const msgEl = document.createElement('div');
    msgEl.className = `nhcb-msg nhcb-${role}`;

    const bubble = document.createElement('div');
    bubble.className = 'nhcb-bubble';
    bubble.textContent = text;
    msgEl.appendChild(bubble);

    if (linkData) {
      const a = document.createElement('a');
      a.href = linkData.url;
      a.target = '_blank';
      a.rel = 'noopener noreferrer';
      a.className = 'nhcb-link-btn';
      a.textContent = linkData.text;
      msgEl.appendChild(a);
    }

    if (quickReplies && quickReplies.length > 0) {
      const qrArea = document.createElement('div');
      qrArea.className = 'nhcb-quick-replies';
      quickReplies.forEach(function (label) {
        const qBtn = document.createElement('button');
        qBtn.className = 'nhcb-qr-btn';
        qBtn.textContent = label;
        qBtn.addEventListener('click', function () {
          qrArea.remove();
          onQR && onQR(label);
        });
        qrArea.appendChild(qBtn);
      });
      msgEl.appendChild(qrArea);
    }

    const messages = document.getElementById('nhcb-messages');
    messages.appendChild(msgEl);
    messages.scrollTop = messages.scrollHeight;
    return msgEl;
  }

  // ------------------------------------------------------------
  // FAQ マッチング
  // ------------------------------------------------------------
  function findAnswer(input) {
    var lower = input.toLowerCase();
    var best = null;
    var bestScore = 0;
    FAQ.forEach(function (item) {
      var score = 0;
      item.keywords.forEach(function (kw) {
        if (lower.indexOf(kw.toLowerCase()) !== -1) score++;
      });
      if (score > bestScore) {
        bestScore = score;
        best = item;
      }
    });
    return bestScore > 0 ? best : null;
  }

  // ------------------------------------------------------------
  // 返信処理
  // ------------------------------------------------------------
  function handleInput(text, onQR) {
    if (!text.trim()) return;
    addMessage('user', text);

    var matched = findAnswer(text);
    if (matched) {
      setTimeout(function () {
        addMessage('bot', matched.answer, matched.link || null, null, null);
        setTimeout(function () {
          addMessage('bot', '他にご質問はありますか？', null, QUICK_REPLIES, onQR);
        }, 300);
      }, 400);
    } else {
      setTimeout(function () {
        addMessage(
          'bot',
          'ご質問ありがとうございます。お答えできる情報が見つかりませんでした。お問い合わせフォームよりご連絡ください。',
          { text: 'お問い合わせフォーム', url: 'https://www.nakatahanger.com/contact/' },
          null,
          null
        );
        setTimeout(function () {
          addMessage('bot', '他にご質問はありますか？', null, QUICK_REPLIES, onQR);
        }, 300);
      }, 400);
    }
  }

  // ------------------------------------------------------------
  // 初期化
  // ------------------------------------------------------------
  function init() {
    injectStyles();
    var els = buildUI();
    var btn = els.btn;
    var win = els.win;
    var isOpen = false;

    function onQR(label) {
      var keyword = QUICK_REPLY_MAP[label] || label;
      handleInput(keyword, onQR);
    }

    function openChat() {
      isOpen = true;
      win.classList.add('nhcb-open');
      btn.setAttribute('aria-expanded', 'true');
      document.getElementById('nhcb-input').focus();
      // 最初のメッセージ
      var messages = document.getElementById('nhcb-messages');
      if (messages.children.length === 0) {
        addMessage('bot', 'こんにちは。NAKATA HANGERのサポートチャットです。ご質問をお気軽にどうぞ。', null, QUICK_REPLIES, onQR);
      }
    }

    function closeChat() {
      isOpen = false;
      win.classList.remove('nhcb-open');
      btn.setAttribute('aria-expanded', 'false');
    }

    btn.addEventListener('click', function () {
      isOpen ? closeChat() : openChat();
    });

    document.getElementById('nhcb-close').addEventListener('click', closeChat);

    var input = document.getElementById('nhcb-input');
    document.getElementById('nhcb-send').addEventListener('click', function () {
      var val = input.value.trim();
      if (!val) return;
      handleInput(val, onQR);
      input.value = '';
    });

    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        var val = input.value.trim();
        if (!val) return;
        handleInput(val, onQR);
        input.value = '';
      }
    });
  }

  // DOM 準備後に実行
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();

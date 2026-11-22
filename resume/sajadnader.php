<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>رزومه هنری | سجاد نادر</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap');

    :root {
      --bg: #f4f5f7;
      --card: #ffffff;
      --dark: #1e2430;
      --dark-2: #2a3242;
      --accent: #c9a24b;
      --accent-soft: #f3e8cf;
      --text: #2b2f36;
      --muted: #6b7280;
      --line: #e5e7eb;
      --radius: 16px;
      --shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Vazirmatn', Tahoma, sans-serif;
      background: var(--bg);
      color: var(--text);
      line-height: 1.8;
      padding: 40px 20px;
    }

    .resume {
      max-width: 1180px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 340px 1fr;
      background: var(--card);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow: hidden;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
      background: var(--dark);
      color: #e8eaed;
      padding: 40px 28px;
      position: relative;
    }

    .sidebar::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, var(--accent), #e0c77a);
    }

    /* آواتار با تصویر */
    .avatar {
      width: 130px;
      height: 130px;
      margin: 0 auto 22px;
      border-radius: 50%;
      background: radial-gradient(circle at 30% 30%, #e0c77a, var(--accent));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 44px;
      font-weight: 800;
      color: var(--dark);
      border: 4px solid rgba(255, 255, 255, 0.12);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
      overflow: hidden;
      position: relative;
    }

    .avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      border-radius: 50%;
    }

    /* اگر تصویر بارگذاری نشد، این لایه پشت تصویر می‌ماند */
    .avatar-fallback {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      z-index: 0;
    }

    .avatar img {
      position: relative;
      z-index: 1;
    }

    .name {
      text-align: center;
      font-size: 26px;
      font-weight: 800;
      letter-spacing: 0.5px;
      color: #fff;
    }

    .title {
      text-align: center;
      font-size: 13px;
      font-weight: 400;
      color: #c3c8d1;
      margin-top: 6px;
      line-height: 1.7;
    }

    .divider {
      height: 1px;
      background: rgba(255, 255, 255, 0.12);
      margin: 26px 0;
    }

    .side-section-title {
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 1.5px;
      color: var(--accent);
      text-transform: uppercase;
      margin-bottom: 14px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .side-section-title svg {
      width: 15px;
      height: 15px;
      fill: var(--accent);
      flex-shrink: 0;
    }

    .contact-item {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      font-size: 13px;
      color: #d4d8df;
      margin-bottom: 12px;
      direction: ltr;
      text-align: left;
    }

    .contact-item svg {
      width: 16px;
      height: 16px;
      fill: var(--accent);
      margin-top: 5px;
      flex-shrink: 0;
    }

    .contact-item span {
      direction: rtl;
      text-align: right;
      unicode-bidi: plaintext;
    }

    .contact-item .ltr-num {
      direction: ltr;
      unicode-bidi: embed;
    }

    /* مهارت‌ها */
    .skill {
      margin-bottom: 12px;
    }

    .skill-name {
      font-size: 13px;
      color: #e8eaed;
      margin-bottom: 6px;
      display: flex;
      justify-content: space-between;
    }

    .skill-bar {
      height: 6px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 4px;
      overflow: hidden;
    }

    .skill-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--accent), #e0c77a);
      border-radius: 4px;
    }

    /* عضویت‌ها */
    .member-item {
      font-size: 13px;
      color: #d4d8df;
      padding-right: 16px;
      position: relative;
      margin-bottom: 9px;
    }

    .member-item::before {
      content: '';
      position: absolute;
      right: 0;
      top: 9px;
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--accent);
    }

    /* ===== MAIN ===== */
    .main {
      padding: 44px 42px;
    }

    .main-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
      flex-wrap: wrap;
      padding-bottom: 22px;
      border-bottom: 2px solid var(--line);
      margin-bottom: 30px;
    }

    .main-header h1 {
      font-size: 30px;
      font-weight: 800;
      color: var(--dark);
      line-height: 1.4;
    }

    .main-header h1 span {
      display: block;
      font-size: 14px;
      font-weight: 500;
      color: var(--accent);
      margin-top: 4px;
      letter-spacing: 1px;
    }

    .badge {
      background: var(--accent-soft);
      color: #8a6d2b;
      font-size: 12px;
      font-weight: 700;
      padding: 8px 16px;
      border-radius: 999px;
      white-space: nowrap;
    }

    .section {
      margin-bottom: 34px;
    }

    .section:last-child {
      margin-bottom: 0;
    }

    .section-title {
      font-size: 17px;
      font-weight: 800;
      color: var(--dark);
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 18px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--line);
      position: relative;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -2px;
      right: 0;
      width: 60px;
      height: 2px;
      background: var(--accent);
    }

    .section-title .icon-box {
      width: 34px;
      height: 34px;
      border-radius: 10px;
      background: var(--accent-soft);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .section-title svg {
      width: 18px;
      height: 18px;
      fill: #8a6d2b;
    }

    /* تایم‌لاین آیتم‌ها */
    .item {
      position: relative;
      padding: 14px 18px;
      border-radius: 12px;
      transition: background 0.2s ease, transform 0.2s ease;
      margin-bottom: 6px;
    }

    .item:hover {
      background: #faf8f2;
      transform: translateX(-3px);
    }

    .item-head {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 14px;
      flex-wrap: wrap;
    }

    .item-title {
      font-size: 14.5px;
      font-weight: 700;
      color: var(--dark);
      line-height: 1.7;
    }

    .item-sub {
      font-size: 12.5px;
      color: var(--muted);
      margin-top: 3px;
      line-height: 1.7;
    }

    .item-code {
      font-size: 11px;
      font-weight: 600;
      color: #8a6d2b;
      background: var(--accent-soft);
      padding: 3px 10px;
      border-radius: 999px;
      white-space: nowrap;
      flex-shrink: 0;
      direction: ltr;
      unicode-bidi: embed;
    }

    .item-desc {
      font-size: 12.5px;
      color: var(--muted);
      margin-top: 5px;
      line-height: 1.8;
    }

    /* گروه‌بندی فیلم‌ها */
    .group-label {
      font-size: 12px;
      font-weight: 700;
      color: var(--accent);
      letter-spacing: 0.5px;
      margin: 18px 0 8px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .group-label::before {
      content: '';
      width: 20px;
      height: 2px;
      background: var(--accent);
      border-radius: 2px;
    }

    /* مقالات */
    .article-item {
      display: flex;
      gap: 12px;
      align-items: flex-start;
      padding: 12px 18px;
      border-radius: 12px;
      transition: background 0.2s ease;
      margin-bottom: 4px;
    }

    .article-item:hover {
      background: #faf8f2;
    }

    .article-num {
      width: 26px;
      height: 26px;
      border-radius: 8px;
      background: var(--accent-soft);
      color: #8a6d2b;
      font-size: 12px;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      margin-top: 2px;
    }

    .article-text {
      font-size: 13.5px;
      color: var(--text);
      line-height: 1.8;
    }

    .article-text em {
      font-style: normal;
      color: var(--muted);
      font-size: 12px;
      display: block;
      margin-top: 2px;
    }

    /* جوایز */
    .award-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
    }

    .award-card {
      display: flex;
      gap: 10px;
      align-items: flex-start;
      background: #fafafb;
      border: 1px solid var(--line);
      border-radius: 12px;
      padding: 12px 14px;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .award-card:hover {
      border-color: var(--accent);
      box-shadow: 0 4px 14px rgba(201, 162, 75, 0.12);
    }

    .award-icon {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      background: var(--accent-soft);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .award-icon svg {
      width: 16px;
      height: 16px;
      fill: #8a6d2b;
    }

    .award-text {
      font-size: 12.5px;
      color: var(--text);
      line-height: 1.7;
    }

    /* ریسپانسیو */
    @media (max-width: 960px) {
      .resume {
        grid-template-columns: 1fr;
      }

      .sidebar {
        padding: 34px 24px;
      }

      .main {
        padding: 32px 24px;
      }

      .award-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 520px) {
      body {
        padding: 16px 10px;
      }

      .main-header h1 {
        font-size: 23px;
      }

      .item-head {
        flex-direction: column;
        gap: 6px;
      }

      .main {
        padding: 26px 16px;
      }
    }

    @media print {
      body {
        background: #fff;
        padding: 0;
      }

      .resume {
        box-shadow: none;
        border-radius: 0;
        grid-template-columns: 300px 1fr;
      }

      .item:hover,
      .article-item:hover,
      .award-card:hover {
        background: transparent;
        transform: none;
        box-shadow: none;
      }
    }
  </style>
</head>
<body>

  <div class="resume">

    <!-- ================= SIDEBAR ================= -->
    <aside class="sidebar">

      <!-- آواتار با تصویر -->
      <div class="avatar">
        <div class="avatar-fallback">س‌ن</div>
        <img
          src="https://simorghtv.com/images/sajadnader.jpg"
          alt="سجاد نادر"
          onerror="this.style.display='none'"
        />
      </div>

      <h2 class="name">سجاد نادر</h2>
      <p class="title">
        تهیه‌کننده، کارگردان و برنامه‌ساز<br />
        مدیرعامل موسسه سینمایی هفت هنر سیمرغ
      </p>

      <div class="divider"></div>

      <!-- اطلاعات تماس -->
      <div class="side-section-title">
        <svg viewBox="0 0 24 24"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24 11.36 11.36 0 003.56.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.36 11.36 0 00.57 3.56 1 1 0 01-.25 1.01l-2.2 2.22z"/></svg>
        اطلاعات تماس
      </div>

      <div class="contact-item">
        <svg viewBox="0 0 24 24"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24 11.36 11.36 0 003.56.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.36 11.36 0 00.57 3.56 1 1 0 01-.25 1.01l-2.2 2.22z"/></svg>
        <span><span class="ltr-num">0912 436 6786</span><br /><span class="ltr-num">0935 463 7055</span></span>
      </div>

      <div class="contact-item">
        <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg>
        <span>ایران</span>
      </div>

      <div class="divider"></div>

      <!-- مشخصات فردی -->
      <div class="side-section-title">
        <svg viewBox="0 0 24 24"><path d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-5 0-9 2.5-9 6v2h18v-2c0-3.5-4-6-9-6z"/></svg>
        مشخصات فردی
      </div>

      <div class="contact-item">
        <svg viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2zm0 16H5V9h14v11z"/></svg>
        <span>متولد <span class="ltr-num">1367</span></span>
      </div>

      <div class="contact-item">
        <svg viewBox="0 0 24 24"><path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
        <span class="ltr-num">کد ملی: 2803571986</span>
      </div>

      <div class="divider"></div>

      <!-- تحصیلات -->
      <div class="side-section-title">
        <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
        تحصیلات
      </div>

      <div class="member-item">کارشناسی کارگردانی سینما</div>
      <div class="member-item">کارشناسی ارشد ادبیات نمایشی</div>

      <div class="divider"></div>

      <!-- مهارت‌ها -->
      <div class="side-section-title">
        <svg viewBox="0 0 24 24"><path d="M22 9l-8-5-8 5v6l8 5 8-5V9zm-10-3.3l6 3.75v5.1l-6 3.75-6-3.75v-5.1l6-3.75z"/></svg>
        مهارت‌ها
      </div>

      <div class="skill">
        <div class="skill-name"><span>تهیه‌کنندگی</span><span>۹۵٪</span></div>
        <div class="skill-bar"><div class="skill-fill" style="width:95%"></div></div>
      </div>
      <div class="skill">
        <div class="skill-name"><span>کارگردانی</span><span>۹۵٪</span></div>
        <div class="skill-bar"><div class="skill-fill" style="width:95%"></div></div>
      </div>
      <div class="skill">
        <div class="skill-name"><span>نویسندگی</span><span>۹۰٪</span></div>
        <div class="skill-bar"><div class="skill-fill" style="width:90%"></div></div>
      </div>
      <div class="skill">
        <div class="skill-name"><span>تدوین</span><span>۸۵٪</span></div>
        <div class="skill-bar"><div class="skill-fill" style="width:85%"></div></div>
      </div>
      <div class="skill">
        <div class="skill-name"><span>برنامه‌سازی رادیو و تلویزیون</span><span>۹۰٪</span></div>
        <div class="skill-bar"><div class="skill-fill" style="width:90%"></div></div>
      </div>

      <div class="divider"></div>

      <!-- عضویت‌ها -->
      <div class="side-section-title">
        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        عضویت‌ها
      </div>

      <div class="member-item">انجمن صنفی بازیگران سینما و تلویزیون ایران</div>
      <div class="member-item">انجمن کارگردانان خانه سینما</div>
      <div class="member-item">انجمن تهیه‌کنندگان آفیف</div>

    </aside>

    <!-- ================= MAIN ================= -->
    <main class="main">

      <header class="main-header">
        <h1>
          رزومه هنری
          <span>سینما · تلویزیون · رادیو · مستند</span>
        </h1>
        <div class="badge">مدیرعامل موسسه سینمایی هفت هنر سیمرغ</div>
      </header>

      <!-- فعالیت ویدیویی داستانی -->
      <section class="section">
        <div class="section-title">
          <div class="icon-box">
            <svg viewBox="0 0 24 24"><path d="M17 10.5V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-3.5l4 4v-11l-4 4z"/></svg>
          </div>
          فعالیت ویدیویی داستانی
        </div>

        <div class="group-label">تله‌فیلم</div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">پرستو می‌آید</div>
            <div class="item-code">پروانه ساخت 92/10/6235</div>
          </div>
          <div class="item-desc">نویسنده، تهیه‌کننده و کارگردان</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">خاطرات سوده</div>
            <div class="item-code">پروانه ساخت 2/87867/155/92</div>
          </div>
          <div class="item-desc">نویسنده، تهیه‌کننده و کارگردان</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">خوابی برای محیا</div>
          </div>
          <div class="item-desc">نویسنده و کارگردان — تهیه‌کننده: غلامرضا ابوالقاسمی — مجری: تراشه تصویر برای شبکه</div>
        </div>

        <div class="group-label">فیلم نیمه‌بلند</div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">چهارشنبه‌سوری</div>
            <div class="item-code">پروانه ساخت 10/18156</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">رجعت</div>
            <div class="item-code">پروانه ساخت 1277</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">دختری در پناهگاه</div>
            <div class="item-code">پروانه ساخت 1155/143</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">عملیات بم</div>
            <div class="item-code">پروانه ساخت 1418</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان</div>
        </div>

        <div class="group-label">فیلم کوتاه</div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">شبی در حرم</div>
            <div class="item-code">پروانه ساخت 10/2691</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">تولدی دیگر</div>
            <div class="item-code">پروانه ساخت 10/3205</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">بی‌انتها</div>
            <div class="item-code">پروانه ساخت 10/4645</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">روزهای عاشورا</div>
            <div class="item-code">پروانه ساخت 985</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">راهیان نور</div>
            <div class="item-code">پروانه ساخت 1533</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">همه‌جاست هیچ‌جا نیست</div>
            <div class="item-code">پروانه ساخت 1233</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">سفر</div>
            <div class="item-code">پروانه ساخت 101425</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">شمارش معکوس</div>
            <div class="item-code">پروانه ساخت 39290</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان</div>
        </div>

      </section>

      <!-- فعالیت مستند -->
      <section class="section">
        <div class="section-title">
          <div class="icon-box">
            <svg viewBox="0 0 24 24"><path d="M17 10.5V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-3.5l4 4v-11l-4 4z"/></svg>
          </div>
          فعالیت مستند
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">مجموعه مستند «فارس ایران کوچک»</div>
          </div>
          <div class="item-desc">تهیه‌کننده و مجری طرح — سال ۱۴۰۰</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">مجموعه مستند «بام‌نشینان»</div>
          </div>
          <div class="item-desc">تهیه‌کننده و مجری طرح — سال ۱۴۰۱</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">مستند سینمایی «خلوتگاه دل»</div>
            <div class="item-code">پروانه ساخت 3206/10</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان — اکران 90/10/18155</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">مستند سینمایی «تا آسمان»</div>
            <div class="item-code">پروانه ساخت 699/11/10</div>
          </div>
          <div class="item-desc">تهیه‌کننده و کارگردان — اکران 91/10/8955</div>
        </div>
      </section>

      <!-- فعالیت رادیویی -->
      <section class="section">
        <div class="section-title">
          <div class="icon-box">
            <svg viewBox="0 0 24 24"><path d="M20 6h-3V4a2 2 0 00-2-2H9a2 2 0 00-2 2v2H4a2 2 0 00-2 2v11a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2zM9 4h6v2H9V4zm11 15H4V8h16v11zM7 12h2v2H7v-2zm0 4h2v2H7v-2zm4-4h2v2h-2v-2zm0 4h2v2h-2v-2zm4-4h2v2h-2v-2zm0 4h2v2h-2v-2z"/></svg>
          </div>
          فعالیت رادیویی
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">سریال صوتی «شب‌های طهران»</div>
          </div>
          <div class="item-desc">تهیه‌کننده، کارگردان و برنامه‌ساز — ۵۰ قسمت ۵۵ دقیقه‌ای</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">سریال صوتی «کافه مه‌آلود»</div>
          </div>
          <div class="item-desc">تهیه‌کننده، کارگردان و برنامه‌ساز — ۱۲ قسمت ۹۰ دقیقه‌ای</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">برنامه «جمعه‌های سیمرغی»</div>
          </div>
          <div class="item-desc">تهیه‌کننده، کارگردان و برنامه‌ساز — از سال ۱۴۰۰ تاکنون، ۳۵۰ قسمت ۷۵ دقیقه‌ای</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">برنامه رادیویی «شب‌های سیمرغ»</div>
          </div>
          <div class="item-desc">تهیه‌کننده، کارگردان و برنامه‌ساز — ۲۰ قسمت ۷۵ دقیقه‌ای</div>
        </div>

        <div class="item">
          <div class="item-head">
            <div class="item-title">پخش برنامه‌های تولیدشده</div>
          </div>
          <div class="item-desc">از رادیوهای ایران، فرهنگ، کتاب‌راه، طاقچه و سایت رادیو سیمرغ</div>
        </div>
      </section>

      <!-- مقالات -->
      <section class="section">
        <div class="section-title">
          <div class="icon-box">
            <svg viewBox="0 0 24 24"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
          </div>
          مقالات چاپ‌شده
        </div>

        <div class="article-item">
          <div class="article-num">۱</div>
          <div class="article-text">
            تأثیر شرایط اجتماعی در تولید آثار سینمایی
            <em>چاپ چهارمین همایش ملی هنرهای نمایشی و دیجیتال</em>
          </div>
        </div>

        <div class="article-item">
          <div class="article-num">۲</div>
          <div class="article-text">
            احیای نگهداری و انتقال آیین و فرهنگ در قالب نمایش
            <em>چاپ پنجمین همایش ملی هنرهای نمایشی</em>
          </div>
        </div>

        <div class="article-item">
          <div class="article-num">۳</div>
          <div class="article-text">
            بازیگری در نمایش رادیویی
            <em>چاپ پنجمین همایش ملی هنرهای نمایشی و دیجیتال</em>
          </div>
        </div>
      </section>

      <!-- مدیریت‌های هنری -->
      <section class="section">
        <div class="section-title">
          <div class="icon-box">
            <svg viewBox="0 0 24 24"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
          </div>
          مدیریت‌های هنری
        </div>

        <div class="item">
          <div class="item-title">مؤسس رادیو سیمرغ</div>
          <div class="item-desc">زیر نظر وزارت ارشاد و رادیو ایران</div>
        </div>

        <div class="item">
          <div class="item-title">مدیریت استودیو و آموزشگاه سینمایی سیمرغ</div>
        </div>

        <div class="item">
          <div class="item-title">مجری طرح جشنواره گل‌ریزان</div>
          <div class="item-desc">سازمان حمایت تهران — سال ۱۴۰۱</div>
        </div>

        <div class="item">
          <div class="item-title">مدیریت و برنامه‌ساز بخش گروه فرهنگی هنری موسسه اکو</div>
          <div class="item-desc">سال ۱۳۹۷</div>
        </div>

        <div class="item">
          <div class="item-title">برگزارکننده جشنواره «صدای شما»</div>
          <div class="item-desc">در موسسه سیمرغ، زیر نظر وزارت فرهنگ و ارشاد اسلامی</div>
        </div>

        <div class="item">
          <div class="item-title">داور شورای انتخاب جشنواره فیلم دانشگاه آزاد اسلامی</div>
          <div class="item-desc">سال ۱۴۰۴</div>
        </div>
      </section>

      <!-- جوایز -->
      <section class="section">
        <div class="section-title">
          <div class="icon-box">
            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          </div>
          جوایز و افتخارات
        </div>

        <div class="award-grid">
          <div class="award-card">
            <div class="award-icon"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
            <div class="award-text">لوح تقدیر و دیپلم افتخار بهترین کارگردانی — جشنواره فیلم شمس</div>
          </div>

          <div class="award-card">
            <div class="award-icon"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
            <div class="award-text">لوح تقدیر و تندیس رادیویی — جشنواره برنامه‌سازان رادیویی</div>
          </div>

          <div class="award-card">
            <div class="award-icon"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
            <div class="award-text">لوح شرکت در جشنواره فیلم رشد</div>
          </div>

          <div class="award-card">
            <div class="award-icon"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
            <div class="award-text">لوح تقدیر و تندیس کارگردانی — انجمن فیلم‌سازان مستقل تهران</div>
          </div>

          <div class="award-card">
            <div class="award-icon"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
            <div class="award-text">لوح تقدیر و دیپلم افتخار تهیه‌کنندگی — جشنواره فیلم دانشگاه آتا ترک ترکیه</div>
          </div>

          <div class="award-card">
            <div class="award-icon"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
            <div class="award-text">لوح تقدیر بهترین نویسندگی — جشنواره شمس</div>
          </div>
        </div>
      </section>

    </main>
  </div>

</body>
</html>
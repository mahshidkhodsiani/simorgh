<!-- ============================================ -->
<!-- دکمه‌ی نصب PWA - کاملاً مستقل، به هیچ فایل دیگه‌ای وابسته نیست -->
<!-- این بلوک رو هرجا خواستید (مثلاً قبل از </body> در index.php) اضافه کنید -->
<!-- ============================================ -->

<button id="pwaInstallBtn" style="display:none;
    position: fixed;
    bottom: 90px;
    right: 30px;
    z-index: 9999;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 14px 24px;
    font-weight: bold;
    font-size: 15px;
    box-shadow: 0 8px 25px rgba(118, 75, 162, 0.4);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: inherit;
">
    📲 نصب رادیو سیمرغ روی صفحه اصلی
</button>

<div id="pwaInstallToast" style="display:none;
    position: fixed;
    bottom: 90px;
    right: 30px;
    left: 30px;
    max-width: 320px;
    margin: 0 auto;
    z-index: 9999;
    background: #28a745;
    color: white;
    border-radius: 15px;
    padding: 16px 20px;
    font-weight: bold;
    text-align: center;
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
">
    ✅ با موفقیت نصب شد!
</div>

<script>
(function() {
    let deferredInstallPrompt = null;
    const installBtn = document.getElementById('pwaInstallBtn');
    const successToast = document.getElementById('pwaInstallToast');

    // مرحله ۱: مرورگر اعلام می‌کنه اپ قابل نصبه -> دکمه رو نشون بده
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault(); // جلوی بنر پیش‌فرض مرورگر رو می‌گیریم تا خودمون دکمه رو کنترل کنیم
        deferredInstallPrompt = e;
        installBtn.style.display = 'flex';
    });

    // مرحله ۲: کاربر روی دکمه‌ی ما کلیک می‌کنه -> پنجره‌ی واقعی نصب مرورگر باز می‌شه
    installBtn.addEventListener('click', async () => {
        if (!deferredInstallPrompt) return;

        installBtn.style.display = 'none';
        deferredInstallPrompt.prompt(); // همون پنجره‌ی Install واقعی مرورگر

        const choice = await deferredInstallPrompt.userChoice;

        if (choice.outcome === 'accepted') {
            // مرحله ۳: کاربر تایید کرد -> پیام موفقیت رو نشون بده
            // (رویداد appinstalled هم پایین‌تر همین کارو دوباره تضمین می‌کنه)
        } else {
            // کاربر انصراف داد -> دکمه رو دوباره نشون بده که بتونه بعداً امتحان کنه
            installBtn.style.display = 'flex';
        }
        deferredInstallPrompt = null;
    });

    // مرحله ۴: تایید نهایی نصب توسط خود مرورگر/سیستم‌عامل
    window.addEventListener('appinstalled', () => {
        installBtn.style.display = 'none';
        successToast.style.display = 'block';
        setTimeout(() => { successToast.style.display = 'none'; }, 4000);
    });

    // اگه از قبل نصب شده (standalone mode)، دیگه دکمه رو نشون نده
    if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
        installBtn.style.display = 'none';
    }
})();
</script>
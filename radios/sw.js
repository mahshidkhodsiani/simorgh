// ⚠️ نسخه رو عوض کردیم تا کش قدیمیِ خراب (که login.php/tehran.php رو اشتباه نگه داشته بود)
// روی دستگاه همه‌ی کاربرها پاک بشه و از نو ساخته بشه.
const CACHE_NAME = 'simorgh-radio-v3';

// ✅ فقط فایل‌های واقعاً استاتیک (بدون وابستگی به لاگین/سشن) اینجا باشن.
// login.php از این لیست حذف شد چون صفحه‌ی دینامیک و وابسته به سشن هست.
const STATIC_CACHE = [
  'includes.php', // فقط اگر واقعا محتوای ثابت (لینک css/js) داره و به سشن ربطی نداره
  'manifest.json',
  '../images/36.png',
  '../images/34.png',
  '../images/35.png',
  '../images/logo1.ico'
];

// صفحات/مسیرهای دینامیک که هرگز نباید Cache-First بشن
// (هر PHP که خروجیش به وضعیت لاگین کاربر بستگی داره باید اینجا باشه)
const NEVER_CACHE_FIRST = [
  'login.php',
  'login_proccess.php',
  'index.php',
  'tehran.php',
  'cafe_meh.php',
  'radio_simorgh.php',
  'logout.php'
];

function isNeverCacheFirst(url) {
  return NEVER_CACHE_FIRST.some(name => url.includes(name));
}

// نصب سرویس‌ورکر
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(STATIC_CACHE))
      .then(() => self.skipWaiting())
  );
});

// فعال‌سازی سرویس‌ورکر - کش‌های نسخه‌ی قبلی (شامل کش خراب login.php) پاک می‌شن
self.addEventListener('activate', e => {
  e.waitUntil(
    caches.keys()
      .then(cacheNames => {
        return Promise.all(
          cacheNames
            .filter(name => name !== CACHE_NAME)
            .map(name => caches.delete(name))
        );
      })
      .then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', e => {
  // فقط GET رو مدیریت کن
  if (e.request.method !== 'GET') {
    e.respondWith(fetch(e.request));
    return;
  }

  const url = e.request.url;

  // ============================================
  // ✅ صفحات دینامیک/وابسته به سشن: همیشه Network First
  // یعنی همیشه اول از سرور بگیر (وضعیت لاگین رو درست نشون بده)،
  // فقط اگه شبکه قطع بود از کش (نسخه‌ی قبلی) به‌عنوان fallback استفاده کن.
  // ============================================
  if (isNeverCacheFirst(url) || e.request.mode === 'navigate') {
    e.respondWith(
      fetch(e.request)
        .then(response => {
          const responseClone = response.clone();
          caches.open(CACHE_NAME).then(cache => cache.put(e.request, responseClone));
          return response;
        })
        .catch(() => {
          return caches.match(e.request).then(cached => {
            if (cached) return cached;
            if (e.request.headers.get('accept')?.includes('text/html')) {
              return caches.match('/offline.html');
            }
          });
        })
    );
    return;
  }

  // ============================================
  // فایل‌های استاتیک واقعی (عکس، آیکون، manifest): Cache First مشکلی نداره
  // ============================================
  e.respondWith(
    caches.match(e.request)
      .then(cachedResponse => {
        if (cachedResponse) {
          fetch(e.request)
            .then(response => {
              caches.open(CACHE_NAME).then(cache => cache.put(e.request, response));
            })
            .catch(() => {});
          return cachedResponse;
        }

        return fetch(e.request)
          .then(response => {
            const responseClone = response.clone();
            caches.open(CACHE_NAME).then(cache => cache.put(e.request, responseClone));
            return response;
          })
          .catch(() => {
            if (e.request.headers.get('accept')?.includes('text/html')) {
              return caches.match('/offline.html');
            }
          });
      })
  );
});
const CACHE_NAME = 'simorgh-radio-v2';
const STATIC_CACHE = [
  'index.php',
  'login.php',
  'includes.php',
  'manifest.json',
  '../images/36.png',
  '../images/34.png',
  '../images/35.png',
  '../images/logo1.ico'
];

// نصب سرویس‌ورکر
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(STATIC_CACHE))
      .then(() => self.skipWaiting())
  );
});

// فعال‌سازی سرویس‌ورکر
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

// استراتژی: ابتدا کش سپس شبکه
self.addEventListener('fetch', e => {
  // فقط درخواست‌های GET را مدیریت کن
  if (e.request.method !== 'GET') {
    e.respondWith(fetch(e.request));
    return;
  }

  e.respondWith(
    caches.match(e.request)
      .then(cachedResponse => {
        // اگر در کش وجود داشت، برگردان
        if (cachedResponse) {
          // اما به‌روزرسانی در پس‌زمینه
          fetch(e.request)
            .then(response => {
              caches.open(CACHE_NAME)
                .then(cache => cache.put(e.request, response));
            })
            .catch(() => {});
          return cachedResponse;
        }

        // اگر در کش نبود، از شبکه بگیر
        return fetch(e.request)
          .then(response => {
            const responseClone = response.clone();
            caches.open(CACHE_NAME)
              .then(cache => cache.put(e.request, responseClone));
            return response;
          })
          .catch(() => {
            // در صورت عدم دسترسی به شبکه، یک صفحه آفلاین نمایش بده
            if (e.request.headers.get('accept').includes('text/html')) {
              return caches.match('/offline.html');
            }
          });
      })
  );
});
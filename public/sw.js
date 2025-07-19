




// const CACHE_NAME = 'mychat-cache-v1';

// self.addEventListener('install', (event) => {
//   console.log('[SW] install');
//   event.waitUntil(
//     caches.open(CACHE_NAME).then((cache) => {  // ✅ pakai `caches`!
//       return cache.addAll([
//         // '/js/app.js',
//         // '/css/app.css',
//         // '/images/logo.png',
//         // '/images/default-avatar.png',
//         // '/storage/avatars/default.png',
//         // '/sstorage/catatan-images/default.png',
//         // '/storage/imgge_catatans/default.png',
//         // '/storage/message_attachments/default.png',
//         '/', // jika ada root index.html
//   '/backend/asset/css/skins/main.css',
//   '/backend/asset/js/page/app.js',
//   '/backend/asset/fonts/vazir/Farsi-Digits/Vazir.woff2',
//   '/backend/asset/img/logo.png',
//   '/favicon.ico',
//   '/sw.js',

//       ]);
//     })
//   );
//   self.skipWaiting();
// });

// self.addEventListener('fetch', function(event) {
//   event.respondWith(
//     caches.match(event.request).then(function(response) {
//       // Coba ambil dari cache
//       if (response) {
//         return response;
//       }
//       // Jika tidak ada ➜ ambil dari network ➜ simpan ke cache
//       return fetch(event.request).then(function(networkResponse) {
//         return caches.open(CACHE_NAME).then(function(cache) {
//           cache.put(event.request, networkResponse.clone());
//           return networkResponse;
//         });
//       });
//     })
//   );
// });



const CACHE_NAME = 'mychat-cache-v1';
const PRECACHE_URLS = [
  '/storage/avatars/default.png',
  '/storage/catatan_images/default.png',
  '/storage/image_catatans/default.png',
  '/storage/message_attachments/default.png',
];


// // Install Service Worker & Precache
// self.addEventListener('install', (event) => {
//   console.log('[SW] Installing...');
//   event.waitUntil(
//     caches.open(CACHE_NAME).then((cache) => {
//       console.log('[SW] Precaching essential assets...');
//       return cache.addAll(PRECACHE_URLS);
//     })
//   );
// });


self.addEventListener('install', (event) => {
  console.log('[SW] Installing...');
  event.waitUntil(
    caches.open(CACHE_NAME).then(async (cache) => {
      console.log('[SW] Precaching essential assets...');
      for (const url of PRECACHE_URLS) {
        try {
          await cache.add(url);
          console.log(`[SW] Cached OK: ${url}`);
        } catch (err) {
          console.error(`[SW] Failed to cache: ${url}`, err);
        }
      }
    })
  );
});

// Activate: Bersihkan cache lama kalau ada
self.addEventListener('activate', (event) => {
  console.log('[SW] Activating...');
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((name) => {
          if (name !== CACHE_NAME) {
            console.log('[SW] Deleting old cache:', name);
            return caches.delete(name);
          }
        })
      );
    })
  );
});

// Fetch: Serve from cache, fallback ke network, lalu simpan runtime
self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      // Kalau di cache, pakai cache
      if (response) {
        return response;
      }

      // Kalau tidak, ambil dari server
      return fetch(event.request)
        .then((networkResponse) => {
          // Filter hanya untuk GET request file statis
          if (!event.request.url.startsWith('http') || event.request.method !== 'GET') {
            return networkResponse;
          }

          return caches.open(CACHE_NAME).then((cache) => {
            cache.put(event.request, networkResponse.clone());
            return networkResponse;
          });
        })
        .catch(() => {
          // Optional: fallback offline.html kalau mau
        });
    })
  );
});


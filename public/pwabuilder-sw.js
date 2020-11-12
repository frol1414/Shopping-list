// This is the "Offline page" service worker

// importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.0.0/workbox-sw.js');

const CACHE = "pwabuilder-page";
const staticAssets = [
    '/',
    'pwabuilder-sw.js',
    'manifest.json',
    'favicon.ico',
    'js/app.js',
    'js/webcodecamjs.js',
    'js/qrcodelib.js',
    'css/bootstrap4.min.css',
    'images/logo.jpeg',
    'images/logo/144x144.png'
];

// TODO: replace the following with the correct offline fallback page i.e.: const offlineFallbackPage = "offline.html";
const offlineFallbackPage = "index.php";

self.addEventListener("message", (event) => {
    if (event.data && event.data.type === "SKIP_WAITING") {
        self.skipWaiting();
    }
});

self.addEventListener('install', async (event) => {
    // console.log('Attempting to install service worker and cache static assets');
    event.waitUntil(
        caches.open(CACHE).then(function(cache) {
            // console.log(123);
            return cache.addAll(staticAssets);
        })
    );
});

// if (workbox.navigationPreload.isSupported()) {
//     workbox.navigationPreload.enable();
// }

self.addEventListener('fetch', function(event) {
    // console.log('Fetch event for ', event.request.url);
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    console.log('Found ', event.request.url, ' in cache');
                    return response;
                }
                console.log('Network request for ', event.request.url);
                return fetch(event.request)

                // TODO 4 - Add fetched files to the cache

            }).catch(error => {
            console.log('Fetch error ', error);
            const cache = caches.open(CACHE);
            const cachedResp = cache.match(offlineFallbackPage);
            return cachedResp;
            // TODO 6 - Respond with custom offline page

        })
    );
})



// if (event.request.mode === 'navigate') {
//     event.respondWith((async () => {
//         try {
//             const preloadResp = await event.preloadResponse;
//
//             if (preloadResp) {
//                 return preloadResp;
//             }
//
//             const networkResp = await fetch(event.request);
//             return networkResp;
//         } catch (error) {
//
//             const cache = await caches.open(CACHE);
//             const cachedResp = await cache.match(offlineFallbackPage);
//             return cachedResp;
//         }
//     })());
// }
// self.addEventListener('fetch', (event) => {
//     if (event.request.mode === 'navigate') {
//         event.respondWith((async () => {
//             try {
//                 const preloadResp = await event.preloadResponse;
//
//                 if (preloadResp) {
//                     return preloadResp;
//                 }
//
//                 const networkResp = await fetch(event.request);
//                 return networkResp;
//             } catch (error) {
//
//                 const cache = await caches.open(CACHE);
//                 const cachedResp = await cache.match(offlineFallbackPage);
//                 return cachedResp;
//             }
//         })());
//     }
// });

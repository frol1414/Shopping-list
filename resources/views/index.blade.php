<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel='manifest' crossorigin="use-credentials" href='manifest.json'>

{{--    <script src="pwabuilder-sw.js"></script>--}}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=5, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Список покупок">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <meta name="theme-color" content="#6243BF">
    <noscript>
        <!-- anchor linking to external file -->
        <a href="https://списокпокупок.рф">Вы не используете javascript</a>
    </noscript>
    <script>

        if(!navigator.onLine) {

            window.location = '/'
        }
        if ("serviceWorker" in navigator) {
            if (navigator.serviceWorker.controller) {
                console.log("[PWA Builder] active service worker found, no need to register");
            } else {
                // Register the service worker
                navigator.serviceWorker
                    .register("pwabuilder-sw.js", {
                        scope: "./"
                    })
                    .then(function (reg) {
                        console.log("[PWA Builder] Service worker has been registered for scope: " + reg.scope);
                    });
            }
        }

    </script>

    <title>Список покупок</title>
    <link rel="apple-touch-icon" href={{ asset('assets/images/logo/180x180.png')}}>
{{--    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{asset('css/bootstrap4.min.css')}}">
</head>
<body style="margin: 0!important;">
<div id="app">
    <app></app>
</div>
{{--<script src="//unpkg.com/javascript-barcode-reader"></script>--}}
<script src="{{ asset('/js/app.js') }}"></script>
<script src="{{ asset('/js/qrcodelib.js') }}"></script>
<script src="{{ asset('/js/webcodecamjs.js') }}"></script>
</body>
</html>

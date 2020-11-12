<html>
<head>
    <meta charset="utf-8">
    <title>Callback</title>
    <script>
        window.opener.postMessage({ token: "{{ $token }}" }, "{{ env('MIX_APP_URL') }}");
        window.close();
    </script>
</head>
<body>
</body>
</html>

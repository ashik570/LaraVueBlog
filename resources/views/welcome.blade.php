<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta name="csrf-token" value="{{ csrf_token() }}"/> -->
    <title>Vue Blog</title>
    <!-- <link rel="stylesheet" href="/css/all.css"> -->
    <link href="{{ asset('public/css/all.css') }}" type="text/css" rel="stylesheet"/>
    <link href="{{ asset('public/css/app.css') }}" type="text/css" rel="stylesheet"/>
    <style>
        .bg-light {
            background-color: #eae9e9 !important;
        }
    </style>
    <script type="text/javascript">
        (function(){
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
        })();
    </script>
</head>
<body>
<div id="app">
    <mainapp></mainapp>
</div>

</body>
<script src="{{ asset('public/js/app.js') }}" type="text/javascript"></script>
<script src="https://kit.fontawesome.com/4d8d9d6354.js" crossorigin="anonymous" type="text/javascript"></script>


</html>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="font-body text-gray-900 antialiased">
    <div id="app">
        <div class="bg-yellow-500">
            <div class="max-w-screen-lg mx-auto px-4">
                <div class="h-16 flex items-center justify-between">
                    <a href="/" class="text-lg font-medium">Laravel Commentator</a>
                    <div>
                        <a href="https://github.com/plmrlnsnts/commentator" target="_blank" rel="noreferrer noopener" class="font-medium inline-flex items-center">
                            <span class="mr-2">Github</span>
                            <svg class="w-5 h-5 text-gray-800 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 6.41L8.7 16.71a1 1 0 1 1-1.4-1.42L17.58 5H14a1 1 0 0 1 0-2h6a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V6.41zM17 14a1 1 0 0 1 2 0v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7c0-1.1.9-2 2-2h5a1 1 0 0 1 0 2H5v12h12v-5z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="py-24 text-center">
                <h1 class="w-full max-w-xl mx-auto text-5xl font-bold text-black tracking-tight leading-none">Hassle free comment system for your next Laravel project.</h1>
                <pre class="bg-black inline-block text-white rounded-lg p-6 font-medium mt-16"><code>composer require plmrlnsnts/commentator</code></pre>
            </div>
        </div>
        <svg class="text-yellow-500 w-full h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="fill-current" fill-opacity="1" d="M0,96L48,128C96,160,192,224,288,250.7C384,277,480,267,576,240C672,213,768,171,864,176C960,181,1056,235,1152,224C1248,213,1344,139,1392,101.3L1440,64L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
        </svg>
        <main class="max-w-screen-lg mx-auto px-4 py-10">
            @yield('content')
        </main>
        <footer class="bg-gray-100 p-4">
            <p class="text-center">Made with <span class="text-red-500">♥️</span> by plrmlnsnts.</p>
        </footer>
    </div>
</body>
</html>

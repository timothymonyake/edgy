<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Edgy</title>
    @include('partials.head')
</head>
<body class="hold-transition login-page">
    @yield('content')

    <!-- Scripts -->
     <x-alert />
     @include('partials.scripts')
</body>
</html>

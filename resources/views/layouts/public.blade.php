<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Epic</title>

    @include('includes.public.__style')
    @stack('extra_style')
  </head>
<body>
    @include('includes.public.__navbar')

    @yield('content')

    @include('includes.public.__footer')

    @include('includes.public.__script')
    @stack('extra_script')
</body>
</html>

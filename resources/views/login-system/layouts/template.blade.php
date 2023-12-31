<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') | EPIC</title>

    <link
      rel="shortcut icon"
      href="{{asset('assets/public/img/favicon.ico')}}"
      type="image/x-icon"
    />

    @include('includes.style')
    @stack('before_style')
</head>

<body>

    <div id="app">
        <section class="section">
            <div class="container mt-2">
                @yield('content')
            </div>
        </section>
    </div>

    {{-- @include('includes.script') --}}
</body>

</html>
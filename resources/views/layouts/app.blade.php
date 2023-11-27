<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{csrf_token()}}" />
  <title>@yield('title')</title>
  @yield('soloStyle'){{-- style khusus pada page tertentu --}}
  @include('includes.style')


</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      
        @include('includes.navbar')

        @include('includes.sidebar')

        @yield('content')

        @include('includes.footer')

    </div>
  </div>
  @include('sweetalert::alert')

  @include('includes.script')

  @yield('soloScript'){{-- script khusus pada page tertentu --}}
</body>

</html>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>

    @include('main.template.tag-manager')

    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="">
    <meta name="description" content="@yield('meta_desc')">
    <meta name="robots" content="@yield('meta_robots')">
    <link rel="canonical" href="{{ Request::url() }}">

    <link rel="stylesheet" href="{{ mix('css/app.css')}}">

    <script defer src="{{ mix('js/app.js') }}"></script>
    @stack('import_head')
    <script defer src="https://code.iconify.design/2/2.0.4/iconify.min.js"></script>
  </head>
  <body>
    @include('main.template.tag-manager-noscript')

    @yield('content')

    @include('main.template.brand')

    @stack('import_foot')
  </body>
</html>

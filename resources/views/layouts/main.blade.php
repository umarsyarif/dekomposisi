<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>{{config('app.name')}} | @yield('title')</title>

  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('datatables/datatables.min.css')}}"/>
  <link rel="stylesheet" type="text/css" href="{{asset('bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">

    <!-- Navbar -->
    @include('partials.topbar')

    <!-- Main Sidebar Container -->
    @include('partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    @yield('content')

    <!-- Main Footer -->
    @include('partials.footer')

    </div>
    <script src="{{asset('js/app.js')}}"></script>
    <script type="text/javascript" src="{{asset('datatables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    @stack('scripts')
</body>
</html>

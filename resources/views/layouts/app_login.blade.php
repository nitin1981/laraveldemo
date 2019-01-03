<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Login</title>
  <link rel="canonical" href="">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="robots" content="index,follow">
  <meta name="author" content="Merrchant" >
  <meta name="x-frame-options" content="allowall" />
  <meta http-equiv="X-Frame-Options" content="sameorigin">
  <link href="https://plus.google.com/103645854063547939782" rel="author">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="_token" content="{!! csrf_token() !!}"/>
  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon"/>
  <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon"/>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- start new theme -->
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('public/vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{ asset('public/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css')}}">
  <link rel="stylesheet" href="{{ asset('public/vendors/iconfonts/simple-line-icon/css/simple-line-icons.css')}}">
  <link rel="stylesheet" href="{{ asset('public/vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{ asset('public/vendors/css/vendor.bundle.addons.css')}}">
  <link rel="stylesheet" href="{{ asset('public/css/style.css')}}">
</head>
<body>
<div class="container-scroller">
<div class="container-fluid page-body-wrapper full-page-wrapper">
<div class="content-wrapper auth p-0 theme-two">
@yield('content')
</div>
</div>
</div>
<!-- plugins:js -->
<script src="{{ asset('public/vendors/js/vendor.bundle.base.js')}}"></script>
<script src="{{ asset('public/vendors/js/vendor.bundle.addons.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="{{ asset('public/js/off-canvas.js')}}"></script>
<script src="{{ asset('public/js/hoverable-collapse.js')}}"></script>
<script src="{{ asset('public/js/misc.js')}}"></script>
<script src="{{ asset('public/js/settings.js')}}"></script>
<script src="{{ asset('public/js/todolist.js')}}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{ asset('public/js/dashboard.js')}}"></script>
<!-- End custom js for this page-->
@yield('js')
</body>
</html>
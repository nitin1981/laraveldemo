<!DOCTYPE html>
<html lang="en">
<head>
  <title>Team Panel | {{ucfirst(trans("message.sidebar.$menu"))}}</title>
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="sidebar-fixed">
<div class="container-scroller">
@include('layouts.includes.header')
<div class="container-fluid page-body-wrapper">
  @include('layouts.includes.sidebar')
  <div class="main-panel">
  @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
      <div class="alert alert-fill-danger" role="alert" style="margin-top: 10px;">
        <i class="mdi mdi-alert-circle"></i>
        {{ $error }}
      </div>
    @endforeach
  @endif
  @if (session('status'))
    <div class="alert alert-fill-success" role="alert" style="background-color:#4CCEAC;margin-top: 10px;border-color: #4CCEAC;">
      <i class="mdi mdi-alert-circle"></i>
      {{ session('status') }}
    </div>
  @endif
  @if(session('success'))
    <div class="alert alert-fill-success" role="alert" style="background-color:#4CCEAC;margin-top: 10px;border-color: #4CCEAC;">
      <i class="mdi mdi-alert-circle"></i>
      {{ session('success') }}
    </div>
  @endif
  @if(session('adminerror'))
    <div class="alert alert-fill-danger" role="alert" style="margin-top: 10px;">
      <i class="mdi mdi-alert-circle"></i>
      {{ $adminerror }}
    </div>
  @endif
  @if(session('adminsuccess'))
    <div class="alert alert-fill-success" role="alert" style="background-color:#4CCEAC;margin-top: 10px;border-color: #4CCEAC;">
      <i class="mdi mdi-alert-circle"></i>
      {{ session('adminsuccess') }}
    </div>
  @endif
  @yield('content')
  @include('layouts.includes.footer')
</div>
</div>
</div>
@yield('js')
</body>
</html>
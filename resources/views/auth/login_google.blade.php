@extends('layouts.app_login')
@section('content')
<div class="row d-flex align-items-stretch">
  <div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
    <div class="slide-content bg-1"></div>
  </div>
  <div class="col-12 col-md-8 h-100 bg-white">
    <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">
      <form class="form-horizontal" role="form" method="POST" action="{{ route('admin-login') }}">
        <h3 class="mr-auto">Hello! let's get started</h3>
        <p class="mb-5 mr-auto">Enter your details below.</p>
        <div class="form-group">
          <a href="https://team.raletta.in/auth/google"><img src="{{url('public/images/glogin.png')}}" style="width: 80%"></a>
        </div>
        <div class="wrapper mt-5 text-gray">
          <p class="footer-text">Copyright © 2018 Raletta Technology Pvt Ltd - All Rights Reserved.</p>
          <ul class="auth-footer text-gray">
            <li><a href="#">Terms & Conditions</a></li>
            <li><a href="#">Cookie Policy</a></li>
          </ul>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

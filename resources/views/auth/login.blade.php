@extends('layouts.app_login')
@section('content')
<div class="row d-flex align-items-stretch">
  <div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
    <div class="slide-content bg-1"></div>
  </div>
  <div class="col-12 col-md-8 h-100 bg-white">
    <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">
      <form class="form-horizontal" role="form" method="POST" action="{{ route('admin-login') }}">
        {!! csrf_field() !!}
        <h3 class="mr-auto">Hello! let's get started</h3>
        <p class="mb-5 mr-auto">Enter your details below.</p>
        @if(session('loginerror'))
          <div class="alert alert-fill-danger" role="alert" style="margin-top: 10px;">
            <i class="mdi mdi-alert-circle"></i>
            {{ session('loginerror') }}
          </div>
        @endif
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
            </div>
            <input type="email" class="form-control" placeholder="Email" name="email" value="{{old('email')}}" />
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="mdi mdi-lock-outline"></i></span>
            </div>
            <input type="password" class="form-control" placeholder="Password" name="password" />
          </div>
        </div>
        <div class="form-group">
          <button class="btn btn-primary submit-btn" type="submit">SIGN IN</button>
        </div>
        <div class="wrapper mt-5 text-gray">
          <p class="footer-text">Copyright © 2019.</p>
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

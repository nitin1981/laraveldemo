@extends('layouts.leanding')
@section('content')

<div class="home-section">
<section class="clearfix">
<div class="row">
 @if (count($errors) > 0)
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li style="text-align: center;color: white;">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
   @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
  <div class="login-container">
    <div class="row login-content">
      <div class="login-title">Reset Password</div>
         <form id="contactForm" method="POST" action="{{ url('/password/email') }}">
          {!! csrf_field() !!}
          <div class="login-input">
               <label for="email">Email</label>
               <input type="email" name="email" id="email" class="name input-text" value="{{old('email')}}" autocomplete="off">
               <span class="login-spin"></span>
          </div>
            <div class="login-button"><button type="submit" id="submit" class="btn reg-btn" href="#">Send Password Reset Link</button></div>
            <div id="msgSubmit" class="h3 text-center hidden"></div> 
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
              <div class="sign-icon">
                <div class="acc-not">Don't have an account  <a href="{{ url('register') }}">Sign up</a></div>
              </div> 
            </div>
        </form> 
    </div>
  </div>
</div>
</section>
  </div>
</div>
@endsection

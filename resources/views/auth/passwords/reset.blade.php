@extends('layouts.leanding')
@section('content')


<div class="home-section">
<section class="clearfix">
<div class="row">

<div class="login-character-animation">
  <div class="hand"></div>
  <div class="hand hand-r"></div>
  <div class="arms">
    <div class="arm"></div>
    <div class="arm arm-r"></div>
  </div>
</div>

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
      <div class="login-title">LOGIN</div>



<form id="contactForm" method="POST" action="{{ url('password/resets/$userData->id') }}">
              {!! csrf_field() !!}
              <input type="hidden" name="id" value="{{ $userData->id }}">
              <input type="hidden" name="token" value="{{ $token }}">
              <input type="hidden" name="c_id" value="{{ $c_id }}">

      <div class="login-input">
         <label for="password">Password</label>
         <input type="password" name="password" id="password" class="input-text" required data-error="Please enter your password" autocomplete="off">
         <span class="login-spin"></span>
      </div>
       <div class="login-input">
         <label for="password_confirmation">password Confirmation</label>
         <input type="password" name="password_confirmation" id="password_confirmation" class="input-text" required data-error="Please enter your password" autocomplete="off">
         <span class="login-spin"></span>
      </div>



        
    

      <div class="login-button"><button type="submit" id="submit" class="btn reg-btn" href="#">Reset Password</button></div>
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

<!-- partial:partials/_sidebar.html -->
<?php
$v = "";
if(!empty(Auth::user()->avatar)) {
  $v = Auth::user()->avatar;
  $v = str_replace('sz=50', 'sz=100', $v);
}
$adwords_icons = array(1=>'icon-energy',2=>'icon-present',3=>'icon-music-tone-alt',4=>'icon-music-tone-alt',5=>'icon-cursor-move',6=>'icon-present',7=>'icon-present',8=>'icon-globe');
?>
<nav class="sidebar sidebar-offcanvas sidebar-dark" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      @if(!empty($v))
      <img src="{{$v}}" alt="Profile image">
      @else
      <img src="{{url('public/uploads/userPic/avatar.jpg')}}" alt="Profile image">
      @endif
      <p class="text-center font-weight-medium">{{Auth::user()->name}}</p>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('dashboard')}}">
        <i class="menu-icon icon-diamond"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    @if(Auth::user()->user_type == 1)
    <li class="nav-item">
      <a class="nav-link" href="{{url('corporates')}}">
        <i class="menu-icon icon-diamond"></i>
        <span class="menu-title">Manage Corporates</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('banks')}}">
        <i class="menu-icon icon-diamond"></i>
        <span class="menu-title">Manage Banks</span>
      </a>
    </li>
    @endif
    @if(Auth::user()->user_type == 2 || Auth::user()->user_type == 3)
    <li class="nav-item">
      <a class="nav-link" href="{{url('invoices')}}">
        <i class="menu-icon icon-diamond"></i>
        <span class="menu-title">Invoices</span>
      </a>
    </li>
    @endif
    @if(Auth::user()->user_type == 2)
    <li class="nav-item">
      <a class="nav-link" href="{{url('vendorrequest')}}">
        <i class="menu-icon icon-diamond"></i>
        <span class="menu-title">Vendor Request</span>
      </a>
    </li>
    @endif
  </ul>
</nav>
<!-- partial -->

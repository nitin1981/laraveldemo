      <!-- partial:partials/_sidebar.html -->
      <?php
      $v = "";
      if(!empty(Auth::user()->avatar)) {
        $v = Auth::user()->avatar; 
        $v = str_replace('sz=50', 'sz=100', $v);
      }
      $adwords_icons = array(1=>'icon-energy',2=>'icon-present',3=>'icon-cup',4=>'icon-cup',5=>'icon-present',6=>'icon-present',7=>'icon-briefcase');
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
          @if(Auth::user()->id==1 || (isset($permissions['remindar']) && $permissions['remindar']==1))
          <li class="nav-item">
            <a class="nav-link" href="{{url('reminderlist')}}">
              <i class="menu-icon icon-speedometer"></i>
              <span class="menu-title">Reminders</span>
              <div class="badge badge-success">{{sizeof($raletta_adwords_today)}}</div>
            </a>
          </li>
          @endif
          @if(Auth::user()->id==1 || (isset($permissions['user']) && $permissions['user']==1))
          <li class="nav-item d-none d-md-block">
            <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts">
              <i class="menu-icon icon-user"></i>
              <span class="menu-title">Users</span>
            </a>
            <div class="collapse" id="page-layouts">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{url('users')}}">All</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{url('activeusers')}}">All Visited Users</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{url('dailyactiveusers')}}">Daily Active Users</a>
                </li>
              </ul>
            </div>
          </li>
          @endif
          @if(Auth::user()->id==1 || (isset($permissions['tools']) && $permissions['tools']==1))
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#apps-dropdown" aria-expanded="false" aria-controls="apps-dropdown">
              <i class="menu-icon icon-settings"></i>
              <span class="menu-title">Tools</span>
            </a>
            <div class="collapse" id="apps-dropdown">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{url('dailyblogview')}}">Blog View Counter</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{url('blogsubscriber')}}">Blog Subscribers</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{url('ralettasubscriber')}}">Raletta Subscribers</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{url('demovisitors')}}">Visitors For Demo</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{url('vouchers')}}">Vouchers</a>
                </li>
              </ul>
            </div>
          </li>
          @endif
          @foreach($leadsdata_sidebar as $leadrow)
          @if(Auth::user()->id==1)
          @if($leadrow['typename']=="Mohini Leads")
          <li class="nav-item d-none d-md-block">
            <a class="nav-link" data-toggle="collapse" href="#sidebar-layouts{{$leadrow['typeid']}}" aria-expanded="false" aria-controls="sidebar-layouts{{$leadrow['typeid']}}">
              <i class="menu-icon {{$adwords_icons[$leadrow['typeid']]}}"></i>
              <span class="menu-title">{{$leadrow['typename']}}</span>
              <div class="badge badge-info">{{$leadrow['leadcount']}}</div>
            </a>
            <div class="collapse" id="sidebar-layouts{{$leadrow['typeid']}}">
              <ul class="nav flex-column sub-menu">
                @foreach($leadrow['leadstatus'] as $statusrow)
                <li class="nav-item">
                  <a class="nav-link" href="{{url('raletta_adwords')}}/{{$leadrow['typeid']}}/{{$statusrow['statusid']}}">{{$statusrow['statusname']}} ( {{$statusrow['recordcount']}} )</a>
                </li>
                @endforeach
              </ul>
            </div>
          </li>
          @else
          <li class="nav-item d-none d-md-block">
            <a class="nav-link" data-toggle="collapse" href="#sidebar-layouts{{$leadrow['typeid']}}" aria-expanded="false" aria-controls="sidebar-layouts{{$leadrow['typeid']}}">
              <i class="menu-icon {{$adwords_icons[$leadrow['typeid']]}}"></i>
              <span class="menu-title">{{$leadrow['typename']}}</span>
              <div class="badge badge-info">{{$leadrow['leadcount']}}</div>
            </a>
            <div class="collapse" id="sidebar-layouts{{$leadrow['typeid']}}">
              <ul class="nav flex-column sub-menu">
                @foreach($leadrow['leadstatus'] as $statusrow)
                <li class="nav-item">
                  <a class="nav-link" href="{{url('raletta_adwords')}}/{{$leadrow['typeid']}}/{{$statusrow['statusid']}}">{{$statusrow['statusname']}} ( {{$statusrow['recordcount']}} )</a>
                </li>
                @endforeach
              </ul>
            </div>
          </li>
          @endif
          @elseif($leadrow['typename']=="Merrchant" && isset($permissions['merrchant_leads']) && $permissions['merrchant_leads']==1)
          <li class="nav-item d-none d-md-block">
            <a class="nav-link" data-toggle="collapse" href="#sidebar-layouts{{$leadrow['typeid']}}" aria-expanded="false" aria-controls="sidebar-layouts{{$leadrow['typeid']}}">
              <i class="menu-icon {{$adwords_icons[$leadrow['typeid']]}}"></i>
              <span class="menu-title">{{$leadrow['typename']}}</span>
              <div class="badge badge-info">{{$leadrow['leadcount']}}</div>
            </a>
            <div class="collapse" id="sidebar-layouts{{$leadrow['typeid']}}">
              <ul class="nav flex-column sub-menu">
                @foreach($leadrow['leadstatus'] as $statusrow)
                <li class="nav-item">
                  <a class="nav-link" href="{{url('raletta_adwords')}}/{{$leadrow['typeid']}}/{{$statusrow['statusid']}}">{{$statusrow['statusname']}} ( {{$statusrow['recordcount']}} )</a>
                </li>
                @endforeach
              </ul>
            </div>
          </li>
          @elseif($leadrow['typename']=="Co-Working" && isset($permissions['coworking_leads']) && $permissions['coworking_leads']==1)
          <li class="nav-item d-none d-md-block">
            <a class="nav-link" data-toggle="collapse" href="#sidebar-layouts{{$leadrow['typeid']}}" aria-expanded="false" aria-controls="sidebar-layouts{{$leadrow['typeid']}}">
              <i class="menu-icon {{$adwords_icons[$leadrow['typeid']]}}"></i>
              <span class="menu-title">{{$leadrow['typename']}}</span>
              <div class="badge badge-info">{{$leadrow['leadcount']}}</div>
            </a>
            <div class="collapse" id="sidebar-layouts{{$leadrow['typeid']}}">
              <ul class="nav flex-column sub-menu">
                @foreach($leadrow['leadstatus'] as $statusrow)
                <li class="nav-item">
                  <a class="nav-link" href="{{url('raletta_adwords')}}/{{$leadrow['typeid']}}/{{$statusrow['statusid']}}">{{$statusrow['statusname']}} ( {{$statusrow['recordcount']}} )</a>
                </li>
                @endforeach
              </ul>
            </div>
          </li>
          @elseif($leadrow['typename']=="Lakeview" && isset($permissions['lakeview_leads']) && $permissions['lakeview_leads']==1)
          <li class="nav-item d-none d-md-block">
            <a class="nav-link" data-toggle="collapse" href="#sidebar-layouts{{$leadrow['typeid']}}" aria-expanded="false" aria-controls="sidebar-layouts{{$leadrow['typeid']}}">
              <i class="menu-icon {{$adwords_icons[$leadrow['typeid']]}}"></i>
              <span class="menu-title">{{$leadrow['typename']}}</span>
              <div class="badge badge-info">{{$leadrow['leadcount']}}</div>
            </a>
            <div class="collapse" id="sidebar-layouts{{$leadrow['typeid']}}">
              <ul class="nav flex-column sub-menu">
                @foreach($leadrow['leadstatus'] as $statusrow)
                <li class="nav-item">
                  <a class="nav-link" href="{{url('raletta_adwords')}}/{{$leadrow['typeid']}}/{{$statusrow['statusid']}}">{{$statusrow['statusname']}} ( {{$statusrow['recordcount']}} )</a>
                </li>
                @endforeach
              </ul>
            </div>
          </li>
          @elseif($leadrow['typename']=="Palmindore" && isset($permissions['palmindore_leads']) && $permissions['palmindore_leads']==1)
          <li class="nav-item d-none d-md-block">
            <a class="nav-link" data-toggle="collapse" href="#sidebar-layouts{{$leadrow['typeid']}}" aria-expanded="false" aria-controls="sidebar-layouts{{$leadrow['typeid']}}">
              <i class="menu-icon {{$adwords_icons[$leadrow['typeid']]}}"></i>
              <span class="menu-title">{{$leadrow['typename']}}</span>
              <div class="badge badge-info">{{$leadrow['leadcount']}}</div>
            </a>
            <div class="collapse" id="sidebar-layouts{{$leadrow['typeid']}}">
              <ul class="nav flex-column sub-menu">
                @foreach($leadrow['leadstatus'] as $statusrow)
                <li class="nav-item">
                  <a class="nav-link" href="{{url('raletta_adwords')}}/{{$leadrow['typeid']}}/{{$statusrow['statusid']}}">{{$statusrow['statusname']}} ( {{$statusrow['recordcount']}} )</a>
                </li>
                @endforeach
              </ul>
            </div>
          </li>
          @elseif($leadrow['typename']=="Services" && isset($permissions['raletta_services']) && $permissions['raletta_services']==1)
          <li class="nav-item d-none d-md-block">
            <a class="nav-link" data-toggle="collapse" href="#sidebar-layouts{{$leadrow['typeid']}}" aria-expanded="false" aria-controls="sidebar-layouts{{$leadrow['typeid']}}">
              <i class="menu-icon {{$adwords_icons[$leadrow['typeid']]}}"></i>
              <span class="menu-title">{{$leadrow['typename']}}</span>
              <div class="badge badge-info">{{$leadrow['leadcount']}}</div>
            </a>
            <div class="collapse" id="sidebar-layouts{{$leadrow['typeid']}}">
              <ul class="nav flex-column sub-menu">
                @foreach($leadrow['leadstatus'] as $statusrow)
                <li class="nav-item">
                  <a class="nav-link" href="{{url('raletta_adwords')}}/{{$leadrow['typeid']}}/{{$statusrow['statusid']}}">{{$statusrow['statusname']}} ( {{$statusrow['recordcount']}} )</a>
                </li>
                @endforeach
              </ul>
            </div>
          </li>
          @elseif($leadrow['typename']=="GRAD" && isset($permissions['raletta_gread']) && $permissions['raletta_gread']==1)
          <li class="nav-item d-none d-md-block">
            <a class="nav-link" data-toggle="collapse" href="#sidebar-layouts{{$leadrow['typeid']}}" aria-expanded="false" aria-controls="sidebar-layouts{{$leadrow['typeid']}}">
              <i class="menu-icon {{$adwords_icons[$leadrow['typeid']]}}"></i>
              <span class="menu-title">{{$leadrow['typename']}}</span>
              <div class="badge badge-info">{{$leadrow['leadcount']}}</div>
            </a>
            <div class="collapse" id="sidebar-layouts{{$leadrow['typeid']}}">
              <ul class="nav flex-column sub-menu">
                @foreach($leadrow['leadstatus'] as $statusrow)
                <li class="nav-item">
                  <a class="nav-link" href="{{url('raletta_adwords')}}/{{$leadrow['typeid']}}/{{$statusrow['statusid']}}">{{$statusrow['statusname']}} ( {{$statusrow['recordcount']}} )</a>
                </li>
                @endforeach
              </ul>
            </div>
          </li>
          @elseif($leadrow['typename']=="Mohini Leads" && isset($permissions['mohini_leads']) && $permissions['mohini_leads']==1)
          <li class="nav-item d-none d-md-block">
            <a class="nav-link" data-toggle="collapse" href="#sidebar-layouts{{$leadrow['typeid']}}" aria-expanded="false" aria-controls="sidebar-layouts{{$leadrow['typeid']}}">
              <i class="menu-icon {{$adwords_icons[$leadrow['typeid']]}}"></i>
              <span class="menu-title">{{$leadrow['typename']}}</span>
              <div class="badge badge-info">{{$leadrow['leadcount']}}</div>
            </a>
            <div class="collapse" id="sidebar-layouts{{$leadrow['typeid']}}">
              <ul class="nav flex-column sub-menu">
                @foreach($leadrow['leadstatus'] as $statusrow)
                <li class="nav-item">
                  <a class="nav-link" href="{{url('raletta_adwords')}}/{{$leadrow['typeid']}}/{{$statusrow['statusid']}}">{{$statusrow['statusname']}} ( {{$statusrow['recordcount']}} )</a>
                </li>
                @endforeach
              </ul>
            </div>
          </li>
          @endif
          @endforeach
          @if(Auth::user()->id==1 || (isset($permissions['employee_roles']) && $permissions['employee_roles']==1))
          <li class="nav-item">
            <a class="nav-link" href="{{url('manageadmin')}}">
              <i class="menu-icon icon-lock"></i>
              <span class="menu-title">Employee Roles</span>
              <div class="badge badge-warning"></div>
            </a>
          </li>
          @endif
        </ul>
      </nav>
      <!-- partial -->
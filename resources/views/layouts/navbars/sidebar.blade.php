<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">

<?php
$user_data = auth()->user();
?>
  <div class="logo">
    <a href="https://creative-tim.com/" class="simple-text logo-normal">
      {{ __('D-Learning') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
          <p>{{ __('Laravel Examples') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      @if($user_data->category == 'T')
      <li class="nav-item{{ $activePage == 'class' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('class.index') }}">
          <i class="material-icons">meeting_room</i>
            <p>{{ __('My Classes') }}</p>
        </a>
      </li>
      @endif
      <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('typography') }}">
          <i class="material-icons">library_books</i>
            <p>{{ __('Typography') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>

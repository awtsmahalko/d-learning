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
        <a class="nav-link" href="">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      @if($user_data->category == 'T')
      <li class="nav-item{{ $activePage == 'class' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('class.index') }}">
          <i class="material-icons">meeting_room</i>
            <p>{{ __('My Classes') }}</p>
        </a>
      </li>
      @endif
    </ul>
  </div>
</div>

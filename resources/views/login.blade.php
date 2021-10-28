<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>D-Learning</title>
  <link rel="apple-touch-icon" sizes="76x76" href="{{ $_REQUEST['public'] }}/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ $_REQUEST['public'] }}/img/favicon.png">
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="{{ $_REQUEST['public'] }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{ $_REQUEST['public'] }}/demo/demo.css" rel="stylesheet" />
</head>

<body class="off-canvas-sidebar">
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  <div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('{{ $_REQUEST['public'] }}/img/login.jpg'); background-size: cover; background-position: top center;align-items: center;" data-color="purple">
      <div class="container" style="height: auto;">
        <div class="row align-items-center">
          <div class="col-lg-6 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="POST" action=" {{ route('login') }}">
              @csrf

              <div class="card card-login card-hidden mb-3">
                <div class="card-header card-header-primary text-center">
                  <h4 class="card-title"><strong>{{ __('Login') }}</strong></h4>
                </div>
                <div class="card-body">
                  <div class="bmd-form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">account_circle</i>
                        </span>
                      </div>
                      <input type="text" name="username" class="form-control" placeholder="{{ __('Username...') }}" value="{{ old('username') }}" required>
                    </div>
                    @if ($errors->has('username'))
                    <div id="username-error" class="error text-danger pl-3" for="username" style="display: block;">
                      <strong>{{ $errors->first('username') }}</strong>
                    </div>
                    @endif
                  </div>
                  <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock_outline</i>
                        </span>
                      </div>
                      <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password...') }}" value="" required>
                    </div>
                    @if ($errors->has('password'))
                    <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                      <strong>{{ $errors->first('password') }}</strong>
                    </div>
                    @endif
                  </div>
                  <div class="form-check mr-auto ml-3 mt-3">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember me') }}
                      <span class="form-check-sign">
                        <span class="check"></span>
                      </span>
                    </label>
                  </div>
                </div>
                <div class="card-footer justify-content-center">
                  <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Lets Go') }}</button>
                </div>
              </div>
            </form>
            <div class="row">
              <div class="col-6">
                @if (Route::has('password.request'))
                <a href="" class="text-light">
                  <small>{{ __('Forgot password?') }}</small>
                </a>
                @endif
              </div>
              <div class="col-6 text-right">
                <a href="{{ route('register') }}" class="text-light">
                  <small>{{ __('Create new account') }}</small>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="{{ $_REQUEST['public'] }}/js/core/jquery.min.js"></script>
  <script src="{{ $_REQUEST['public'] }}/js/core/popper.min.js"></script>
  <script src="{{ $_REQUEST['public'] }}/js/core/bootstrap-material-design.min.js"></script>
  <script src="{{ $_REQUEST['public'] }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="{{ $_REQUEST['public'] }}/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="{{ $_REQUEST['public'] }}/js/plugins/sweetalert2.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="{{ $_REQUEST['public'] }}/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="{{ $_REQUEST['public'] }}/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="{{ $_REQUEST['public'] }}/js/plugins/jquery.dataTables.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="{{ $_REQUEST['public'] }}/js/plugins/arrive.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="{{ $_REQUEST['public'] }}/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ $_REQUEST['public'] }}/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
  @stack('js')

</body>

</html>
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

    <?php if ($_REQUEST['baseUrl'] == '') { ?>
        <meta http-equiv="origin-trial" content="Am01xjFqpxOImHK8gajNHIO/9EFQDJWrQLU0EmlKWHBW5XXDYazLgMkyNzsqI2lZczgyVtWELZo0ItcK8RAEFAIAAABgeyJvcmlnaW4iOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiLCJmZWF0dXJlIjoiVW5yZXN0cmljdGVkU2hhcmVkQXJyYXlCdWZmZXIiLCJleHBpcnkiOjE2NTg4Nzk5OTl9">
    <?php } else { ?>
        <meta http-equiv="origin-trial" content="ApGj5uJHFroHyhR9pmEGY7NGGkOoEBZ3q8xpNRzJnXIWStJ3al/haDgZog6T3tMF7ZaMoNkT4p76/qTi+yHp0QAAAAB3eyJvcmlnaW4iOiJodHRwczovL2p1YW5jb2Rlci5jb206NDQzIiwiZmVhdHVyZSI6IlVucmVzdHJpY3RlZFNoYXJlZEFycmF5QnVmZmVyIiwiZXhwaXJ5IjoxNjU4ODc5OTk5LCJpc1N1YmRvbWFpbiI6dHJ1ZX0=">
    <?php } ?>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <link href="{{ $_REQUEST['public'] }}/summernote/summernote-bs4.min.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ $_REQUEST['public'] }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ $_REQUEST['public'] }}/demo/demo.css" rel="stylesheet" />

    <link href="{{ $_REQUEST['public'] }}/select2/css/select2.css" rel="stylesheet">

    <?php
    $auth = auth()->user();
    ?>
    <script>
        window.sessionUserId = "{{ Auth::id() }}";
        window.sessionCategory = "{{ $auth->category; }}";
        window.sessionFullname = "{{ $auth->fname . ' ' . $auth->mname . ' ' . $auth->lname ; }}";

        window.sessionFname = "{{ $auth->fname; }}";
        window.sessionMname = "{{ $auth->mname; }}";
        window.sessionLname = "{{ $auth->lname ; }}";
        window.sessionEmail = "{{ $auth->email; }}";
        window.sessionUsername = "{{ $auth->username; }}";

        window.baseUrl = "{{ $_REQUEST['baseUrl'] }}";
    </script>
</head>

<body>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <div id="app">
        <app></app>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ $_REQUEST['public'] }}/js/core/jquery.min.js"></script>
    <script src="{{ $_REQUEST['public'] }}/js/core/popper.min.js"></script>
    <script src="{{ $_REQUEST['public'] }}/js/core/bootstrap-material-design.min.js"></script>
    <script src="{{ $_REQUEST['public'] }}/summernote/summernote-bs4.min.js" type="text/javascript"></script>
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


    <script src="{{ $_REQUEST['public'] }}/select2/js/select2.js" type="text/javascript"></script>

    <script src="{{ $_REQUEST['mixAppBlade'] }}" type="text/javascript"></script>
    <script type="text/javascript">
        function success_add() {
            swal("Success!", "Successfully added entry!", "success");
        }

        function success_update() {
            swal("Success!", "Successfully updated entry!", "success");
        }

        function success_delete() {
            swal("Success!", "Successfully deleted entry!", "success");
        }

        function entry_already_exists() {
            swal("Cannot proceed!", "Entry already exists!", "warning");
        }

        function failed_query(data) {
            swal("Failed to execute query!", data, "warning");
            //alert('Something is wrong. Failed to execute query. Please try again.');
        }

        function alertMe(data) {
            swal("Message", data, "info");
        }

        function checkAll(ele, ref) {
            var checkboxes = document.getElementsByClassName(ref);
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    //console.log(i)
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }
    </script>
</body>

</html>
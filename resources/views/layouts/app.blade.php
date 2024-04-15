<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/main.css" rel="stylesheet" />
    <!-- CSRF Token for AJAX calls -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- jQuery and Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- Custom Styles -->
    <style>
        .info-container {
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 20px;
            border-radius: 8px;
        }

        .info-container h2 {
            color: #333;
        }

        .info-container p {
            color: #666;
        }

        #email {
            padding: 10px;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: calc(100% - 24px); /* Input width - padding */
        }

        #subscribe {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #subscribe:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        $(document).ready(function() {
            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
</head>
<body>
    <div id="app">
        @include('include.navbar')
        @if(Session::has('user_name'))
            @if(Session::get('user_role') == 'Superadmin')
                    @yield('superadmincontent')
                @elseif(Session::get('user_role') == 'Admin')
                    @yield('admincontent')
                @elseif(Session::get('user_role') == 'Normal') 
                @yield('content')
                @include('include.menubar')
            @endif
        @else
            @yield('content')
            <main class="py-4">
                @include('include.menubar')
            </main>
        @endif
    </div>
</body>
</html>

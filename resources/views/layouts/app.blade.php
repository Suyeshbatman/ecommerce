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
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/main.css" rel="stylesheet" />
    </head>
<body>
    <div id="app">
        @include('include.navbar')
        @if(Session::has('user_name'))
            @if(Session::get('user_role') == 'Superadmin')
                    @yield('superadmincontent')
                @elseif(Session::get('user_role') == 'Admin')
                    @yield('admincontent')
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

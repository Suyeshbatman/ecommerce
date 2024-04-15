<!-- Navigation for Super Admins-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="#!">HamroMercado</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <!-- Intentionally left blank for Super Admins, or you can add admin specific links here -->
            </ul>
            <div class="d-flex align-items-center">
                @if(Session::has('user_name'))
                    <span class="user-name" style="font-weight: bold; margin-right: 10px;">{{ Session::get('user_name') }}</span>
                    <a href="{{ route('logout') }}" class="btn btn-outline-dark">
                        Logout
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-dark" style="margin-right: 5px;">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-dark">
                        Register
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>

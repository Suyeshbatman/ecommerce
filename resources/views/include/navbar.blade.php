<!-- Navigation for Super Admins-->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color:#f06123">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="{{route('home')}}" style="font-weight: bold; font-size: 1.55rem; color: #3b3938;">HamroMercado</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <!-- Intentionally left blank for Super Admins, or you can add admin specific links here -->
            </ul>
            @if(in_array(Session::get('user_role'), ['Admin', 'Normal'])) <!-- Hide cart for Superadmins -->
                <a href="{{url('/cartdata')}}">
                <button class="btn btn-outline-dark" type="submit" style="font-weight: bold; font-size: 1.35rem; color: #3b3938;">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                </button>
                </a>
            @endif
            @if(Session::has('user_role'))
            <div class="user-info ms-3 pe-3" style="border-right: 2px solid #ddd;">
                @if(Session::has('user_name'))
                <span class="user-name" style="font-weight: bold; font-size: 1.35rem; color: #3b3938;">{{ Session::get('user_name')}}</span>        
                @endif
            </div>
            <a href="{{route('logout')}}" class="ms-3">
                <button class="btn btn-outline-dark" style="font-weight: bold; font-size: 1.35rem; color: #3b3938;">
                    Logout
                </button>
            </a>
            @endif
            @if(in_array(Session::get('user_role'), ['Superadmin', 'Admin']))
                <a href="{{ route('login') }}" class="ms-3">
                    <button class="btn btn-outline-dark" style="font-weight: bold; font-size: 1.35rem; color: #3b3938;">
                        Dashboard
                    </button>
                </a>
            @endif
            @unless(Session::has('user_name'))
                <a href="{{route('userlogin')}}">
                    <button class="btn btn-outline-dark" style="font-weight: bold; font-size: 1.35rem; color: #3b3938;">
                        Login
                    </button>
                </a>
                <a href="{{route('register')}}">
                    <button class="btn btn-outline-dark" style="font-weight: bold; font-size: 1.35rem; color: #3b3938;">
                        Register
                    </button>
                </a>
            @endunless
        </div>
    </div>
</nav>

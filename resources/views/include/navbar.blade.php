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
            @if(Session::get('user_role') != 'Superadmin') <!-- Hide cart for Superadmins -->
            <form class="d-flex">
                <button class="btn btn-outline-dark" type="submit">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                </button>
            </form>
            @endif
            <div class="user-info ms-3 pe-3" style="border-right: 2px solid #ddd;">
                @if(Session::has('user_role'))
                <span class="user-role" style="font-weight: bold; margin-right: 10px;">Role: {{ Session::get('user_role')}}</span>
                @endif
                @if(Session::has('user_name'))
                <span class="user-name" style="font-weight: bold; color: #007bff;">{{ Session::get('user_name')}}</span>        
                @endif
            </div>
            <a href="{{route('logout')}}" class="ms-3">
                <button class="btn btn-outline-dark" >
                    Logout
                </button>
            </a>
            @unless(Session::has('user_name'))
                <a href="{{route('login')}}">
                    <button class="btn btn-outline-dark">
                        Login
                    </button>
                </a>
                <a href="{{route('register')}}">
                    <button class="btn btn-outline-dark">
                        Register
                    </button>
                </a>
            @endunless
        </div>
    </div>
</nav>

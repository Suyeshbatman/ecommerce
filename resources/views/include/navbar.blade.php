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
            <form class="d-flex">
                <button class="btn btn-outline-dark" type="submit">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                </button>
            </form>
            @if(Session::has('user_role'))
            User: 
            {{ Session::get('user_role')}} :
            @endif
            @if(Session::has('user_name'))
            {{ Session::get('user_name')}}        
                <a href="{{route('logout')}}">
                    <button class="btn btn-outline-dark" >
                        <!-- <i class="bi-cart-fill me-1"></i> -->
                        Logout
                    </button>
                </a>
            @else
                <a href="{{route('login')}}">
                    <button class="btn btn-outline-dark">
                        Login
                    </button>
                </a>
                <a href="{{route('register')}}">
                    <button class="btn btn-outline-dark" >
                        Register
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>

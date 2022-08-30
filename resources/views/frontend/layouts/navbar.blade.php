<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color:#212529" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}">
            Hiring Portal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                @if(auth()->guard('user')->user())
                    <li class="nav-item"><a class="nav-link" href="{{route('user.dashboard')}}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary btn-sm" href="#" role="button" onclick="Logout()">Logout</a></li>
                @else  
                    <li class="nav-item"><a class="nav-link" href="{{route('register')}}">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Login</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
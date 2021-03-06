<nav class="navbar navbar-expand-md navbar-dark sticky-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route('index')}}">Langschool</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link @if(Request::is('/')) active @endif" aria-current="page" href="{{route('index')}}">Strona główna</a>
                </li>
                <li>
                    <a class="nav-link @if(Request::is('courses')) active @endif" aria-current="page" href="{{route('courses.index')}}">Kursy</a>
                </li>
                @if(Auth::check())
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('courses/user')) active @endif" aria-current="page" href="{{route('courses.user')}}">Moje kursy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('user')) active @endif" aria-current="page" href="{{route('user.index')}}">Konto</a>
                    </li>
                    @if(Auth::user()->role->name == 'teacher')
                        <li class="nav-item">
                            <a class="nav-link @if(Request::is('user/teacher-panel')) active @endif" aria-current="page" href="{{route('user.teacher-panel')}}">Panel nauczyciela</a>
                        </li>
                    @endif
                    @if(Auth::user()->role->name == 'admin')
                        <li class="nav-item">
                            <a class="nav-link @if(Request::is('user/admin-panel')) active @endif" aria-current="page" href="{{route('user.admin-panel')}}">Użytkownicy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Request::is('language')) active @endif" aria-current="page" href="{{route('language.index')}}">Języki</a>
                        </li>
                    @endif
                @endif
            </ul>
            <div class="d-flex">
                @if(Auth::check())
                    <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-success">{{Auth::user()->first_name}}, wyloguj się...</a>
                @else
                <a href="{{route('login')}}" class="btn btn-outline-success">Zaloguj się...</a>
                <a href="{{route('register')}}" class="btn btn-outline-success">Zarejestruj się...</a>
                @endif
            </div>
        </div>
    </div>
</nav>

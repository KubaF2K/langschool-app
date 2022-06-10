<!DOCTYPE html>
<html lang="pl">
@include("shared.head", ['title' => 'Strona nie istnieje!'])
<body class="pb-4">
@include("shared.nav")
<div class="container pt-4">
    @if (session('msg'))
        <div class="alert alert-success">
            {{session('msg')}}
        </div>
    @endif
    <div class="alert alert-danger">
        <h3>Coś poszło nie tak!</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <p>Podana strona nie istnieje, kliknij któryś z linków powyżej aby przejść do innej strony.</p>
    </div>

</div>
@include("shared.foot")
</body>
</html>

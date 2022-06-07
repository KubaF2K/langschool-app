<!DOCTYPE html>
<html lang="pl">
@include('shared.head', ['title' => 'Edytowanie użytkownika'])
<body class="pt-5 pb-4">
@include('shared.nav')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container pt-2">
    <h2>Edytuj dane</h2>
    <form method="POST" action="{{route('courses.update')}}">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="name">Nazwa użytkownika</label>
            <input class="form-control" id="name" name="name" value="{{Auth::user()->name}}">
        </div>
        <div>
            <label class="form-label">Hasło<input class="form-control" type="password" disabled value="password"/></label>
            <a href="{{route('user.reset-password')}}" class="btn btn-outline-primary">Resetuj hasło</a>
        </div>
        <div class="mb-3">
            <label class="form-label" for="first_name">Imię</label>
            <input class="form-control" id="first_name" name="first_name" value="{{Auth::user()->first_name}}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="last_name">Nazwisko</label>
            <input class="form-control" id="last_name" name="last_name" value="{{Auth::user()->last_name}}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" class="form-control" type="email" value="{{Auth::user()->email}}">
        </div>
        <input type="submit" class="btn btn-outline-primary" value="Zmień">
    </form>
</div>
@include('shared.foot')
</body>
</html>
{{--TODO
panel moje kursy
panel kursy nauczyciela
admin panel
tabela zapisy/historia, jakieś rabaty
--}}

<!DOCTYPE html>
<html lang="pl">
@include('shared.head', ['title' => 'Dane użytkownika'])
<body class="pt-5 pb-4">
@include('shared.nav')
<div class="container pt-2">
    <h2>Profil użytkownika</h2>
    <p>Nazwa użytkownika: {{Auth::user()->name}}</p>
    <p>
        <label>Hasło<input type="password" disabled value="password"/></label>
        <a href="{{route('user.reset-password')}}" class="btn btn-outline-primary">Resetuj hasło</a>
    </p>
    <p>Imię i nazwisko: {{Auth::user()->first_name}} {{Auth::user()->last_name}}</p>
    <p>Adres email: {{Auth::user()->email}}</p>
    @if (Auth::user()->role_id != 2)
        <p>Rola: {{__(Auth::user()->role->name)}}</p>
    @endif
    @if (Auth::user()->language_id != null)
        <p>Język: {{Auth::user()->language->name}}</p>
    @endif
    <p>Utworzono: {{Auth::user()->created_at}}</p>
    <a href="{{route('user.edit')}}" class="btn btn-outline-primary">Zmień dane</a>
</div>
@include('shared.foot')
</body>
</html>

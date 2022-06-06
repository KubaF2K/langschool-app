<!DOCTYPE html>
<html lang="pl">
@include('shared.head', ['title' => 'Langschool'])
<body class="pt-5 pb-4">
@include('shared.nav', ['title' => 'Langschool'])
<div class="container pt-2">
    <h2>Profil użytkownika</h2>
    <p>Nazwa użytkownika: {{Auth::user()->name}}</p>
    <p>Imię i nazwisko: {{Auth::user()->first_name}} {{Auth::user()->last_name}}</p>
    <p>Adres email: {{Auth::user()->email}}</p>
    <a href="{{route('user.edit')}}" class="btn btn-primary-outline">Zmień</a>
    @if (Auth::user()->role_id != 2)
        <p>Rola: {{__(Auth::user()->role()->name)}}</p>
    @endif
    @if (Auth::user()->language_id != null)
        <p>Język: {{Auth::user()->language()->name}}</p>
    @endif
    <p>Utworzono: {{Auth::user()->created_at}}</p>
</div>
@include('shared.foot')
</body>
</html>

<!DOCTYPE html>
<html lang="pl">
@include("shared.head", ['title' => 'Langschool'])
<body class="pt-5 pb-4">
@include("shared.nav", ['title' => 'Langschool'])
<div class="container pt-4">
    <div class="row">
        <h1>Nasze kursy:</h1>
        @forelse($languages as $language)
            <div class="container border rounded p-4 m-3">
                <h2 class="border-bottom p-3 w-auto"><img class="img-thumbnail" style="height: 5rem" src="{{asset('storage/'.$language->code.'.svg')}}" alt="{{$language->name}}"/> Język {{$language->name}}</h2>
                @forelse($language->courses as $course)
                    <div class="row p-2 @if(!$loop->last) border-bottom @endif">
                        <h3>{{$course->name}}</h3>
                        <p>{{$course->description}}</p>
                        <h4>Liczba godzin: {{$course->hours}}</h4>
                        <h4>Cena: {{$course->price}} zł</h4>
                        <h5>Prowadzący: {{$course->teacher->first_name.' '.$course->teacher->last_name}}</h5>
{{--                        TODO Button view, sign up--}}
                    </div>
                @empty
                    <h3>Brak kursów!</h3>
                @endforelse
            </div>
        @empty
            <h3>Brak kursów!</h3>
        @endforelse
    </div>
    <div class="row">
        <h2>Kontakt</h2>
        <p>
            Adres:<br>
            Jana Pawła II 12<br>
            12-345 Miejscowice
        </p>
        <p>
            Telefon: +48 987 654 321
        </p>
        <p>
            Email: kursy@langschool.pl
        </p>
    </div>
</div>
@include("shared.foot")
</body>
</html>

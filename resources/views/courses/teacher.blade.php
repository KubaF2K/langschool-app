<!DOCTYPE html>
<html lang="pl">
@include('shared.head', ['title' => 'Moje kursy'])
<body class="pt-5 pb-4">
@include('shared.nav')
<div class="container pt-2">

    <h2>Kursy języka: {{Auth::user()->language->name}}</h2>
    <a href="{{route('courses.add')}}" class="btn-outline-primary btn">Dodaj kurs</a>
    <div class="container border rounded">
        @forelse($courses as $course)
            <div class="row p-2 @if(!$loop->last) border-bottom @endif">
                <h3>{{$course->name}}</h3>
                <p>{{$course->description}}</p>
                <h4>Liczba godzin: {{$course->hours}}</h4>
                <h4>Cena: {{$course->price}} zł</h4>
                <h5>Prowadzący: {{$course->teacher->first_name.' '.$course->teacher->last_name}}</h5>
                @if($course->teacher == Auth::user())
                    <a href="{{route('courses.edit', ['id' => $course->id])}}">Edytuj</a>
                    <a href="{{route('courses.delete', ['id' => $course->id])}}">Usuń</a>
                @endif
            </div>
        @empty
            <h3>Brak kursów!</h3>
        @endforelse
    </div>
</div>
@include('shared.foot')
</body>
</html>

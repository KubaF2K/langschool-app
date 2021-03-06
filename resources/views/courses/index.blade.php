<!DOCTYPE html>
<html lang="pl">
@include("shared.head", ['title' => 'Kursy'])
<body class="pb-4">
@include("shared.nav")
<div class="container pt-4">
    @if (session('msg'))
        <div class="alert alert-success">
            {{session('msg')}}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(Auth::check() && Auth::user()->role->name == 'admin')
        <a href="{{route('courses.add')}}" class="btn-outline-primary btn">Dodaj kurs</a>
    @endif
    <h3>Każdy kolejny kurs 10% taniej! (Do -30%)</h3>
    <div class="row">
        <h1>Nasze kursy:</h1>
        @forelse($languages as $language)
            @if($language->courses->count() > 0 || (Auth::check() && Auth::user()->role->name != 'user'))
            <div class="container border rounded p-4 m-3">
                @if(Auth::check() && Auth::user()->role->name == 'teacher' && Auth::user()->language_id == $language->id)
                    <a href="{{route('courses.add')}}" class="btn-outline-primary btn float-end">Dodaj kurs</a>
                @endif
                <h2 class="border-bottom p-3 w-auto"><img class="img-thumbnail" style="height: 5rem" src="{{asset('storage/'.$language->code.'.svg')}}" alt="{{$language->name}}"/> Język {{$language->name}}</h2>
                @forelse($language->courses as $course)
                    <div class="row p-2 @if(!$loop->last) pb-3 border-bottom @endif">
                        <h3>{{$course->name}}</h3>
                        <h4>Cena: {{$course->price}} zł</h4>
                        <h5>Prowadzący: {{$course->teacher->first_name.' '.$course->teacher->last_name}}</h5>
                        <div class="mt-2"><a href="{{route('courses.view', $course->id)}}" class="btn-primary btn">Wyświetl</a>
                        @if(Auth::check() && ($course->teacher_id == Auth::id() || Auth::user()->role->name == 'admin'))
                            <form method="post" action="{{route('courses.delete')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{$course->id}}"/>
                                <input class="btn btn-outline-danger float-end" type="submit" value="Usuń" onclick="return confirm('Czy na pewno chcesz usunąć ten kurs?')"/>
                            </form>
                            <a href="{{route('courses.edit', $course->id)}}" class="btn-outline-success btn float-end me-2">Edytuj</a>
                        @endif
                        </div>
                    </div>
                @empty
                    <h3>Brak kursów!</h3>
                @endforelse
            </div>
            @endif
        @empty
            <h3>Brak kursów!</h3>
        @endforelse
    </div>

</div>
@include("shared.foot")
</body>
</html>

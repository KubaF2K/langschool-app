<!DOCTYPE html>
<html lang="pl">
@include('shared.head', ['title' => 'Moje kursy'])
<body class="pt-5 pb-4">
@include('shared.nav')
<div class="container pt-2">
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
    <h2 class="mb-4">Zapisy na kursy</h2>
    <div class="container border rounded">
        @forelse($courses as $course)
            <div class="row p-2 @if(!$loop->last) border-bottom @endif">
                <h3>{{$course->name}}</h3>
                <h4>Liczba godzin: {{$course->hours}}</h4>
                <h4>Cena: {{$course->pivot->cost}} zł</h4>
                <h5>Prowadzący: {{$course->teacher->first_name.' '.$course->teacher->last_name}}</h5>
                <h5>Data zapisu: {{$course->pivot->created_at}}</h5>
                <form method="post" action="{{route('courses.decline')}}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{Auth::id()}}">
                    <input type="hidden" name="course_id" value="{{$course->id}}">
                    <input type="submit" class="btn-outline-danger btn" value="Anuluj prośbę">
                </form>
            </div>
        @empty
            <h3 class="p-4">Nie zapisałeś/aś się na żadne kursy!</h3>
        @endforelse
    </div>
    <h2>Moje kursy</h2>
    <div class="container border rounded">
        @forelse($attended_courses as $course)
            <div class="row p-2 @if(!$loop->last) border-bottom @endif">
                <h3>{{$course->name}}</h3>
                <h4>Liczba godzin: {{$course->hours}}</h4>
                <h5>Prowadzący: {{$course->teacher->first_name}} {{$course->teacher->last_name}} ({{$course->teacher->email}})</h5>
                <h5>Data przyjęcia: {{$course->pivot->created_at}}</h5>
                <form method="post" action="{{route('courses.remove-user')}}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{Auth::id()}}">
                    <input type="hidden" name="course_id" value="{{$course->id}}">
                    <input type="submit" class="btn-outline-danger btn" value="Wypisz z kursu">
                </form>
            </div>
        @empty
            <h3 class="p-4">Nie bierzesz udziału w żadnych kursach!</h3>
        @endforelse
    </div>
</div>
@include('shared.foot')
</body>
</html>

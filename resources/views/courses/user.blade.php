<!DOCTYPE html>
<html lang="pl">
@include('shared.head', ['title' => 'Moje kursy'])
<body class="pt-5 pb-4">
@include('shared.nav')
<div class="container pt-2">
    {{--    TODO zapisy na kursy (pending)    --}}
    <h2>Moje kursy</h2>
    <div class="container border rounded">
        @forelse($courses as $course)
            <div class="row p-2 @if(!$loop->last) border-bottom @endif">
                <h3>{{$course->name}}</h3>
                <p>{{$course->description}}</p>
                <h4>Liczba godzin: {{$course->hours}}</h4>
                <h4>Cena: {{$course->price}} zł</h4>
                <h5>Prowadzący: {{$course->teacher->first_name.' '.$course->teacher->last_name}}</h5>
                <h5>Data zapisu: {{$course->pivot->created_at}}</h5>
                {{-- TODO wypisanie z kursu
                                <form action="{{route('courses.enroll')}}" method="POST">--}}
                {{--                    @csrf--}}
                {{--                    <input name="course_id" type="number" value="{{$course->id}}" style="display: none;"/>--}}
                {{--                    <input type="submit" value="Zapisz się" class="btn btn-primary"/>--}}
                {{--                </form>--}}
            </div>
        @empty
            <h3>Brak kursów!</h3>
        @endforelse
    </div>
</div>
@include('shared.foot')
</body>
</html>

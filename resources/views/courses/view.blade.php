<!DOCTYPE html>
<html lang="pl">
@include("shared.head", ['title' => $course->name])
<body class="pt-5 pb-4">
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
    <div class="container col-12 text-center">
        <img class="rounded mx-auto col-4" src="{{asset('/storage/'.$course->language->code.'.svg')}}" alt="{{$course->language->name}}">
    </div>
    <div class="row">
        <div class="row p-2">
            <h3>{{$course->name}}</h3>
            <p>{{$course->description}}</p>
            <h4>Liczba godzin: {{$course->hours}}</h4>
            @if(Auth::check() && Auth::user()->attendedCourses()->count() > 0)
                <h4>Cena: {{$course->price-($course->price / 10 * min(3, Auth::user()->attendedCourses()->count()))}} zł (-{{min(3, Auth::user()->attendedCourses()->count())}}0%)</h4>
            @else
                <h4>Cena: {{$course->price}} zł</h4>
            @endif
            <h5>Prowadzący: {{$course->teacher->first_name.' '.$course->teacher->last_name}}</h5>
            @if(Auth::check() && ($course->teacher_id == Auth::id() || Auth::user()->role->name == 'admin'))
                <div class="mb-2">
                    <a href="{{route('courses.edit', $course->id)}}" class="btn-success btn">Edytuj</a>
                    <a onclick="if(confirm('Czy na pewno chcesz usunąć ten kurs?')) window.location.replace('{{route('courses.delete', $course->id)}}');" class="btn-danger btn">Usuń</a>
                </div>
            @endif
            @if(Auth::id() != $course->teacher_id)
                <form action="{{route('courses.enroll')}}" method="POST">
                    @csrf
                    <input name="course_id" type="hidden" value="{{$course->id}}"/>
                    <input type="submit" value="Zapisz się" class="btn btn-primary"/>
                </form>
            @endif
        </div>
    </div>
</div>
@include("shared.foot")
</body>
</html>

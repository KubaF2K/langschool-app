<!DOCTYPE html>
<html lang="pl">
@include('shared.head', ['title' => 'Panel nauczyciela'])
<body class="pb-4">
@include('shared.nav')
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
<div class="container pt-4">
    <h2>Niezaakceptowane zapisy na kursy</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Użytkownik</th>
                <th scope="col">Kurs</th>
                <th scope="col">Koszt</th>
                <th scope="col">Data zapisu</th>
                <th scope="col">Adres email</th>
                <th scope="col">Akceptuj</th>
                <th scope="col">Ignoruj</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
                @foreach($course->users as $user)
                    <tr>
                        <td>{{$user->first_name}} {{$user->last_name}}</td>
                        <td>{{$course->name}}</td>
                        <td>{{$user->pivot->cost}} zł</td>
                        <td>{{$user->pivot->created_at}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <form method="post" action="{{route('courses.accept')}}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                <input type="submit" value="Akceptuj" class="btn-outline-success btn">
                            </form>
                        </td>
                        <td>
                            <form method="post" action="{{route('courses.decline')}}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                <input type="submit" value="Odrzuć" class="btn-outline-danger btn"
                                       onclick="return confirm('Czy na pewno chcesz odrzucić tą prośbę? Użytkownik zostanie o tym powiadomiony.');"/>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <h2>Prowadzone kursy</h2>
    <div class="container">
        @forelse($courses as $course)
            <div class="row p-2 @if(!$loop->last) border-bottom @endif">
                <h3>{{$course->name}}</h3>
                <p>{{$course->description}}</p>
                <h4>Liczba godzin: {{$course->hours}}</h4>
                <h4>Cena: {{$course->price}} zł</h4>
                <div class="mb-2">
                    <form action="{{route('courses.delete')}}" method="post">
                        @csrf
                        <a href="{{route('courses.edit', $course->id)}}" class="btn-success btn">Edytuj</a>
                        <input type="hidden" name="id" value="{{$course->id}}"/>
                        <input type="submit" class="btn-danger btn" value="Usuń"
                               onclick="return confirm('Czy na pewno chcesz usunąć ten kurs?')"/>
                    </form>
                </div>
                <h5>Kursanci</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Imię</th>
                            <th scope="col">Nazwisko</th>
                            <th scope="col">Adres email</th>
                            <th scope="col">Data przyjęcia</th>
                            <th scope="col">Usuń</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($course->participants as $user)
                            <tr>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->pivot->created_at}}</td>
                                <td>
                                    <form method="post" action="{{route('courses.remove-user')}}">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{$course->id}}">
                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                        <input type="submit" value="Usuń" class="btn-outline-danger btn"
                                               onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika z kursu? Użytkownik zostanie o tym powiadomiony.')"/>
                                    </form>
                                </td>
                            </tr>
                        @empty
                        <tr><th colspan="4">Brak kursantów!</th></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @empty
            <h3>Brak kursów!</h3>
        @endforelse
    </div>
</div>
@include('shared.foot')
</body>
</html>

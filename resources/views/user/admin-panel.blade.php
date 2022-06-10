<!DOCTYPE html>
<html lang="pl">
@include("shared.head", ['title' => 'Panel administracyjny'])
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
    <h2>Użytkownicy</h2>
    <table>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nazwa użytkownika</th>
                <th scope="col">Imię</th>
                <th scope="col">Nazwisko</th>
                <th scope="col">Email</th>
                <th scope="col">Data utworzenia</th>
                <th scope="col">Język</th>
                <th scope="col">Rola</th>
                <th scope="col">Aktualizuj</th>
                <th scope="col">Usuń</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <form method="post" action="{{route('user.update')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <th>{{$user->id}}</th>
                        <td><input class="form-control" type="text" name="name" value="{{$user->name}}"></td>
                        <td><input class="form-control" type="text" name="first_name" value="{{$user->first_name}}"></td>
                        <td><input class="form-control" type="text" name="last_name" value="{{$user->last_name}}"></td>
                        <td><input class="form-control" type="email" name="email" value="{{$user->email}}" disabled></td>
                        <td><input class="form-control" type="text" disabled value="{{$user->created_at}}"></td>
                        <td>
                            <select class="form-control w-auto" name="language_id">
                                <option value="" @if(Auth::user()->language == null) selected @endif>Nieokreślony</option>
                                @foreach($languages as $language)
                                    <option value="{{$language->id}}" @if($language->id == $user->language_id) selected @endif>{{$language->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control w-auto" name="role_id">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}" @if($role->id == $user->role_id) selected @endif>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input class="btn-outline-primary btn" type="submit" value="Aktualizuj"></td>
                    </form>
                    <td>
                        <form method="post" action="{{route('user.delete')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <input type="submit" class="btn-outline-danger btn" value="Usuń"
                                   onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');"/>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include("shared.foot")
</body>
</html>

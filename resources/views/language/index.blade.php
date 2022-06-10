<!DOCTYPE html>
<html lang="pl">
@include("shared.head", ['title' => 'Języki'])
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
        <a href="{{route('language.add')}}" class="btn-outline-primary btn">Dodaj język</a>
    @endif
    <div class="row">
        @forelse($languages as $language)
            <div class="container border rounded p-4 m-3">
                <h2 class="border-bottom p-3 w-auto">
                    <img class="img-thumbnail" style="height: 5rem" src="{{asset('storage/'.$language->code.'.svg')}}"
                         alt="{{$language->name}}"/>
                    Język {{$language->name}}
                </h2>
                <p>{{$language->description}}</p>
                @if(Auth::check() && Auth::user()->role->name == 'admin')
                    <p>Kod: {{$language->code}}</p>
                    <p>Data utworzenia: {{$language->created_at}}</p>
                    <p>Data edycji: {{$language->updated_at}}</p>
                    <form action="{{route('language.delete')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$language->id}}">
                        <input type="submit" value="Usuń" class="btn btn-outline-danger float-end"
                               onclick="return confirm('Czy na pewno chcesz usunąć ten język?')">
                        <a href="{{route('language.edit', ['id' => $language->id])}}"
                           class="btn btn-outline-primary float-end">Edytuj</a>
                    </form>
                @endif
            </div>
        @empty
            <h3>Brak języków!</h3>
        @endforelse
    </div>

</div>
@include("shared.foot")
</body>
</html>

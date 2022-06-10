<!DOCTYPE html>
<html lang="pl">
@include('shared.head', ['title' => 'Edycja języka'])
<body class="pb-4">
@include('shared.nav')
<div class="container pt-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h2>Edycja</h2>
    <form method="POST" action="{{route('language.update')}}">
        @csrf
        <input type="hidden" name="id" value="{{$language->id}}"/>
        <div class="mb-3">
            <label for="code" class="form-label">Kod</label>
            <input class="form-control @error('code') is-invalid @enderror" type="text" name="code" id="code"
                   value="{{$language->code}}">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nazwa</label>
            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"
                   value="{{$language->name}}">
        </div>
        <div>
            <label for="description" class="form-label">Opis</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{$language->description}}</textarea>
        </div>
        <input type="submit" class="btn btn-outline-primary" value="Edytuj">
    </form>
</div>
@include('shared.foot')
</body>
</html>

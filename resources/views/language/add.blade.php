<!DOCTYPE html>
<html lang="pl">
@include('shared.head', ['title' => 'Dodawanie języka'])
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
    <h2>Dodawanie</h2>
    <form method="POST" action="{{route('language.create')}}">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">Kod</label>
            <input class="form-control @error('code') is-invalid @enderror" type="text" name="code" id="code"
                   value="{{old('code')}}">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nazwa</label>
            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"
                   value="{{old('name')}}">
        </div>
        <div>
            <label for="description" class="form-label">Opis</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{old('description')}}</textarea>
        </div>
        <input type="submit" class="btn btn-outline-primary" value="Dodaj">
    </form>
</div>
@include('shared.foot')
</body>
</html>

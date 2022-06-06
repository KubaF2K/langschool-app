<!DOCTYPE html>
<html lang="pl">
@include('shared.head', ['title' => 'Dodawanie kursu'])
<body class="pt-5 pb-4">
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
    <h2>Nowy kurs</h2>
    <form method="POST" action="{{route('courses.create')}}">
        @csrf
        <div class="mb-3" @if(Auth::user()->role->name == 'teacher') style="display: none;" @endif>
            <label class="form-label" for="language_id">Język</label>
            <select class="form-control @error('language_id') is-invalid @enderror" id="language_id" name="language_id">
                @foreach($languages as $language)
                    <option value="{{$language->id}}" @if(old('language_id') == null ? ($language == Auth::user()->language) : (old('language_id') == $language->id)) selected @endif>{{$language->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3" @if(Auth::user()->role->name == 'teacher') style="display: none;" @endif>
            <label class="form-label" for="teacher_id">Prowadzący</label>
            <select class="form-control @error('teacher_id') is-invalid @enderror" id="teacher_id" name="teacher_id">
                @foreach($teachers as $teacher)
                    <option value="{{$teacher->id}}" @if(old('teacher_id') == null ? ($teacher == Auth::user()) : (old('teacher_id') == $teacher->id)) selected @endif>{{$teacher->first_name.' '.$teacher->last_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="name">Nazwa</label>
            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="hours">Ilość godzin</label>
            <input class="form-control @error('hours') is-invalid @enderror" id="hours" name="hours" type="number" min="0" step="1" value="{{old('hours')}}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">Opis</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{old('description')}}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="price">Cena</label>
            <input class="form-control @error('price') is-invalid @enderror" id="price" name="price" type="number" min="0" step="0.01" value="{{old('price')}}"> zł
        </div>
        <input type="submit" class="btn btn-outline-primary" value="Dodaj">
    </form>
</div>
@include('shared.foot')
</body>
</html>

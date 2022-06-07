<!DOCTYPE html>
<html lang="pl">
@include('shared.head', ['title' => 'Edycja kursu'])
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
    <h2>Edycja</h2>
    <form method="POST" action="{{route('courses.edit', $course->id)}}">
        @csrf
        <div class="mb-3" @if(Auth::user()->role->name == 'teacher') style="display: none;" @endif>
            <label class="form-label" for="teacher_id">Prowadzący</label>
            <select class="form-control @error('teacher_id') is-invalid @enderror" id="teacher_id" name="teacher_id">
                @foreach($teachers as $teacher)
                    <option value="{{$teacher->id}}" @if(old('teacher_id') == null ? ($teacher == $course->teacher) : (old('teacher_id') == $teacher->id)) selected @endif>{{$teacher->first_name.' '.$teacher->last_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="name">Nazwa</label>
            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $course->name)}}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="hours">Ilość godzin</label>
            <input class="form-control @error('hours') is-invalid @enderror" id="hours" name="hours" type="number" min="0" step="1" value="{{old('hours', $course->hours)}}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">Opis</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{old('description', $course->description)}}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="price">Cena</label>
            <input class="form-control @error('price') is-invalid @enderror" id="price" name="price" type="number" min="0" step="0.01" value="{{old('price', $course->price)}}"> zł
        </div>
        <input type="submit" class="btn btn-outline-primary" value="Edytuj">
    </form>
</div>
@include('shared.foot')
</body>
</html>

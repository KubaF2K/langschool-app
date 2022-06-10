<!DOCTYPE html>
<html lang="pl">
@include('shared.head', ['title' => 'Usunięcie z kursu'])
<body>
<x-application-logo class="w-20 h-20 fill-current text-gray-500"></x-application-logo>
<h3>
    Odrzucenie aplikacji
</h3>
<p>
    Zostałeś/aś usunięty/a z kursu {{$course->name}}.
    W razie pytań proszę o kontakt z {{$teacher->email}}
</p>
@include('shared.foot')
</body>
</html>

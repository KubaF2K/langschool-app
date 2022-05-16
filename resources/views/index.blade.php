<!DOCTYPE html>
<html lang="pl">
@include("shared.head", ['title' => 'Langschool'])
<body>
@include("shared.nav", ['title' => 'Langschool'])
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{asset('storage/carousel1.webp')}}" class="d-block w-100" alt="Półka z książkami">
        </div>
        <div class="carousel-item">
            <img src="{{asset('storage/carousel2.webp')}}" class="d-block w-100" alt="Osoba czytająca słownik">
        </div>
        <div class="carousel-item">
            <img src="{{asset('storage/carousel3.webp')}}" class="d-block w-100" alt="Osoby uczące się w klasie">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Poprzedni</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Następny</span>
    </button>
</div>
<div class="container-fluid">
    <div class="row">
        <h2>O naszej szkole</h2>
        <p>
            Nasza szkoła pozwala nauczyć się języków obcych szybko i skutecznie. Potrzebujesz znać jakiś język do pracy?
            Może potrzebujesz certyfikatu? U nas możesz brać udział w różnych kursach które pomogą ci poznać dowolny
            język jaki mamy w ofercie. Mamy kadrę pomocnych i pracowitych prowadzących którzy nauczą cię wszystkiego w
            miłej i przyjemnej atmosferze. Nie zwlekaj, zapisz się na kurs już dziś!
        </p>
    </div>
    <div class="row">
        <h2>Najpopularniejsze kursy</h2>
{{--        TODO 4 karty z najpopularniejszymi--}}
    </div>
    <div class="row">
        <h2>Kontakt</h2>
        <p>
            Adres:<br>
            Jana Pawła II 12<br>
            12-345 Miejscowice
        </p>
        <p>
            Telefon: +48 987 654 321
        </p>
        <p>
            Email: kursy@langschool.pl
        </p>
    </div>
</div>
@include("shared.foot")
</body>
</html>

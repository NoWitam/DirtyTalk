<div class="card-holder">

    @isset($bot)
        <div>
            <div class="card">   
                <div class="slideshow-container">

                    @foreach ($bot['photos'] as $photo)
                        <div class="mySlides fade">
                            <img src="{{ $photo }}" alt="{{ $bot['name'] }} zdjęcie numer {{ $loop->iteration }}">
                        </div>
                    @endforeach

                    <nav>
                        @foreach ($bot['photos'] as $photo)
                            <a class="dot @if($loop->iteration == 1) active @endif" onclick="currentSlide({{ $loop->iteration }})"></a>
                        @endforeach
                    </nav>

                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>
                <div class="name">
                    <h2>Karolina 25</h2>
                </div>
                <hr>
                <div class="description">
                    Miła brunetka lubiąca podróżować i poznawać nowych ludzi.
                </div>
            </div>
        </div>

        <div class="buttons">
            <button wire:click="match(false)" class="remove">Odrzuć</button>
            <button wire:click="match(true)" class="accept">Napisz</button>
        </div>
    @else
        <h2>Brak pasujących do ciebie par. Zajrzyj tu kiedy indziej ..</h2>
    @endisset


</div>

@push('js')
    <script src="{{ asset('js/slider.js') }}"></script>
@endpush
<div class="card-holder">
    <div>
        <div class="card">   
            @isset($bot)
                <div class="slideshow-container">

                    @foreach ($bot['photos'] as $photo)
                        <div class="mySlides fade">
                            <img src="{{ Storage::url('public/'.$photo) }}" alt="{{ $bot['name'] }} zdjęcie numer {{ $loop->iteration }}">
                        </div>
                    @endforeach

                
                    <!-- Next and previous buttons -->
                    <nav>
                        <a class="dot active" onclick="currentSlide(1)"></a>
                        <a class="dot" onclick="currentSlide(2)"></a>
                        <a class="dot" onclick="currentSlide(3)"></a>
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
            @endisset
        </div>
    </div>

    <div class="buttons">
        <a class="remove">Odrzuć</a>
        <a class="accept">Napisz</a>
    </div>

</div>

@push('js')
    <script src="{{ asset('js/slider.js') }}"></script>
@endpush
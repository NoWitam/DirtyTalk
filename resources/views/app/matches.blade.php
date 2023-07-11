@extends('layouts.app')

@section('title', $bot ? $bot['name'] : 'Pary')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/matches.css') }}">
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endpush

@section('content')
    @isset($pair)
        <div id="matches">

            @livewire('chat', ['pair' => $pair])
            <hr>
            <div id="profile">
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
                    <h2>{{ $bot['name'] . " " . $bot['age'] }}</h2>
                </div>
                <hr>
                <div class="description">
                    {{ $bot['description'] }}
                </div>
            </div>

        </div>
    @endisset
@endsection

@push('js')
    <script src="{{ asset('js/slider.js') }}"></script>
@endpush
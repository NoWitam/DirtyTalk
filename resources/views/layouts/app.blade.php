@extends('layouts.main')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('body')

    <header>
        <div class="logo">
            <h1> Dirty Talk </h1>
            <img src="{{ asset('img/kiss.png') }}" alt="Kiss">
        </div>

        <nav>
            <a @if(Route::is('search')) class="active" @endif href="{{ route('search') }}">Szukaj</a>
            <a @if(Route::is('matches')) class="active" @endif href="{{ route('matches') }}">Pary</a>
        </nav>
    </header>

    <div class="content">
        @yield('content')
    </div>

@endsection
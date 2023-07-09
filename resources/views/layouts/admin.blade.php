@extends('layouts.main')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('body')

    <header>
        <div class="logo">
            <h1> Dirty Talk </h1>
            <img src="{{ asset('img/kiss.png') }}" alt="Kiss">
        </div>

        <nav>
            <a @if(Route::is('admin.users')) class="active" @endif href="{{ route('admin.users') }}">Użytkownicy</a>
            <a @if(Route::is('admin.bots')) class="active" @endif href="{{ route('admin.bots') }}">Boty</a>
        </nav>
    </header>


    @yield('content')
@endsection
@extends('layouts.main')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endpush

@section('body')

    <div class="content">
        <span>
            <h1 class="neonText text-center">Dirty Talk</h1>
            <h2 class="neonText text-center">Gorące dziewczyny w zasięgu <br> twojego smartfona</h2>
        </span>


        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h2 class="neonText">Logowanie</h2>
            <input type="text" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Hasło">
            <input type="submit" value="Zaloguj sie">
        </form>
    </div>

@endsection
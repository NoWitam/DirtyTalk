@extends('layouts.app')

@section('title', 'Szukaj randki')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endpush

@section('content')
    @livewire('bot-matcher')
@endsection
@extends('layouts.app')

@section('title', 'cekusergroupmiddleware')

@section('content')
    <h2>checkusergroupmiddleware</h2>

    @if (Auth::check())
        <p>Welcome, {{ Auth::user()->name }}!</p>
    @endif
@endsection

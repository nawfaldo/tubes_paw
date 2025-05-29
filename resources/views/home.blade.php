@extends('layouts.app')

@section('title', 'home')

@section('content')
    <h2>home</h2>

    @if (Auth::check())
        <p>Welcome, {{ Auth::user()->name }}!</p>
    @endif

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection

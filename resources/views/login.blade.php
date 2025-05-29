@extends('layouts.app')

@section('title', 'login')

@section('content')
    <h2>login</h2>

    @if (session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
        @csrf

        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Send</button>
    </form>
@endsection

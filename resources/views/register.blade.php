@extends('layouts.app')

@section('title', 'register')

@section('content')
    <h2>register</h2>

    <form action="{{ route('register.submit') }}" method="POST">
        @csrf

        <div>
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

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

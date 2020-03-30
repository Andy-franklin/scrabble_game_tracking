@extends('layouts.base')

@section('title', 'New Game')

@section('content')

    <h1>New Game</h1>

    <form method="post" action="{{ route('game.store') }}">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label>
            Player One
            <select name="player_one">
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
        </label>

        <label>
            Player One Score
            <input type="number" name="player_one_score"/>
        </label>

        <label>
            Player Two
            <select name="player_two">
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
        </label>

        <label>
            Player Two Score
            <input type="number" name="player_two_score"/>
        </label>

        <button type="submit">Save</button>
    </form>

@endsection

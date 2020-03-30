@extends('layouts.base')

@section('title', 'Update Game: ' . $game->id)

@section('content')

    <h1>Update {{ $game->id }}</h1>

    <form method="post" action="{{ route('game.update', $game->id) }}">
        @csrf
        {{method_field('PATCH')}}

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @foreach ($game->members()->get() as $index => $gameMember)
            <label>
                Player {{ $index + 1 }}
                <select name="player_{{$index + 1}}">
                    @foreach ($members as $member)
                        {{-- @TODO: Add previously selected --}}
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                Player {{ $index + 1 }} Score
                <input type="number" name="player_{{ $index + 1 }}_score"/>
            </label>
        @endforeach

        <button type="submit">Save</button>
    </form>

@endsection

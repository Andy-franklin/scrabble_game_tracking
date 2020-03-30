@extends('layouts.base')

@section('title', 'Game Index')

@section('content')
    <h1>Games</h1>

    <table>
        <thead>
        <tr>
            <th>Game ID</th>
            <th>Players</th>
            <th>Played</th>
            <th><!-- Actions --></th>
        </tr>
        </thead>
        <tbody>
        @foreach($games as $game)
            <tr>
                <td>{{ $game->id }}</td>
                <td>
                    <ul>
                    @foreach ($game->members as $member)
                        <li>{{ $member->name }}</li>
                    @endforeach
                    </ul>
                </td>
                <td>{{ $game->created_at }}</td>
                <td>
                    <ul>
                        <li><a href="{{ route('game.show', $game->id) }}">View</a></li>
                        <li><a href="{{ route('game.edit', $game->id) }}">Edit</a></li>
                        <li><a href="">Delete</a></li>
                    </ul>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

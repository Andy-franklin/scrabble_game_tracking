@extends('layouts.base')

@section('title', 'Leaderboard')

@section('content')
    <div class="container">
        <div class="row">
            <h1 class="mt-5">The Leaderboard</h1>
        </div>
        <div class="row mt-5 mb-5">
            <div class="col">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Average Score</th>
                        <th scope="col"># of Games</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($top10Players as $player)
                            <tr>
                                <td>{{ $player->name }}</td>
                                <td>{{ $player->average_score }}</td>
                                <td>{{ $player->game_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5 mb-5 align-items-center">
            <div class="col-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">Highest Scoring Game</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $bestScore->name }} VS {{ $bestScore->opponent_name }}</h6>
                                <p class="text-muted">Played at: {{ $bestScore->created_at }}</p>
                                <hr/>
                                <div class="row">
                                    <div class="col-auto">
                                        <p><b>Winner</b>: {{ $bestScore->name }}</p>
                                        <p>Score: {{ $bestScore->score }}</p>
                                    </div>
                                    <div class="col-auto">
                                        <p><b>Loser</b>: {{ $bestScore->opponent_name }}</p>
                                        <p>Score: {{ $bestScore->opponent_score }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">Lowest Scoring Game</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $worstScore->name }} VS {{ $worstScore->opponent_name }}</h6>
                                <p class="text-muted">Played at: {{ $bestScore->created_at }}</p>
                                <hr/>
                                <div class="row">
                                    <div class="col-auto">
                                        <p><b>Winner</b>: {{ $worstScore->opponent_name }}</p>
                                        <p>Score: {{ $worstScore->opponent_score }}</p>
                                    </div>
                                    <div class="col-auto">
                                        <p><b>Loser</b>: {{ $worstScore->name }}</p>
                                        <p>Score: {{ $worstScore->score }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

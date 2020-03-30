@extends('layouts.base')

@section('title', 'Member Profile')

@section('content')
<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col">
            @if (!$member->bestMatch())
                <div class="alert alert-info" role="alert">
                    This member is new! Why not arrange a game with them?
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <a href="https://placeholder.com"><img src="https://via.placeholder.com/150"></a>
                        </div>
                        <div class="col">
                            <h5 class="card-title">Arrange a scrabble game with {{ $member->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $member->bio }}</h6>
                            <p>by Email: <a href="mailto:{{ $member->email }}" class="card-link">{{ $member->email }}</a></p>
                            <p>by Phone: <a href="tel:{{ $member->phone_number }}" class="card-link">{{ $member->phone_number }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">Stats</h5>
                            <p>Wins: {{ $member->getWins() }}</p>
                            <p>Losses: {{ $member->getLosses() }}</p>
                            <p>Average Score: {{ $member->averageScore() }}</p>
                            @if ($member->bestMatch())
                                <p>Best Match (Highest Score):</p>
                                <ul>
                                    <li><b>My Score:</b> {{ $member->bestMatch()->pivot->score }}</li>
                                    <li>Opponent Score{{ $member->bestMatch()->opponents($member)->count() > 0 ? 's' : '' }}:</li>
                                    @foreach ($member->bestMatch()->opponents($member)->get() as $index => $opponent)
                                        <b>Opponent {{ $index + 1 }}</b>
                                        <ul>
                                            <li>Name: {{ $opponent->name }}</li>
                                            <li>Score: {{ $opponent->pivot->score }}</li>
                                        </ul>
                                    @endforeach
                                    <li>When: {{ $member->bestMatch()->created_at }}</li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

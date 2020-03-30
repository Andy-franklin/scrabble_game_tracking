@extends('layouts.base')

@section('title', 'Member Profile')

@section('content')

<h1>Members</h1>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Bio</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Wins</th>
            <th>Losses</th>
            <th><!-- Actions --></th>
        </tr>
    </thead>
    <tbody>
        @foreach($members as $member)
        <tr>
            <td>{{ $member->name }}</td>
            <td>{{ $member->bio }}</td>
            <td>{{ $member->email }}</td>
            <td>{{ $member->phone_number }}</td>
            <td>{{ $member->getWins() }}</td>
            <td>{{ $member->getLosses() }}</td>
            <td>
                <ul>
                    <li><a href="{{ route('member.show', $member->id) }}">View</a></li>
                    <li><a href="{{ route('member.edit', $member->id) }}">Edit</a></li>
                    <li><a href="">Delete</a></li>
                </ul>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

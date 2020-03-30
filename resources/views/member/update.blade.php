@extends('layouts.base')

@section('title', 'Update Member: ' . $member->name)

@section('content')

<h1>Update {{ $member->name }}</h1>

<form method="post" action="{{ route('member.update', $member->id) }}">
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

    <label>
        Name
        <input type="text" name="name" value="{{ $member->name }}"/>
    </label>
    <label>
        Bio
        <textarea name="bio">{{ $member->bio }}</textarea>
    </label>
    <label>
        Email Address
        <input type="text" name="email" value="{{ $member->email }}"/>
    </label>
    <label>
        Phone Number
        <input type="text" name="phone_number" value="{{ $member->phone_number }}"/>
    </label>
    <button type="submit">Save</button>
</form>

@endsection

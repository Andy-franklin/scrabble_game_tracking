@extends('layouts.base')

@section('title', 'Member Profile')

@section('content')

<h1>New Member</h1>

<form method="post" action="{{ route('member.store') }}">
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
        Name
        <input type="text" name="name"/>
    </label>
    <label>
        Bio
        <textarea name="bio"></textarea>
    </label>
    <label>
        Email Address
        <input type="text" name="email"/>
    </label>
    <label>
        Phone Number
        <input type="text" name="phone_number"/>
    </label>
    <button type="submit">Save</button>
</form>

@endsection

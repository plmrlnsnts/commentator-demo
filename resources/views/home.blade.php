@extends('layouts.app')

@section('content')
<div>
    @guest
        <form class="flex items-center justify-center py-24" action="{{ route('login') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $user->email }}">
            <input type="hidden" name="password" value="password">
            <button type="submit" class="bg-yellow-500 rounded font-medium px-4 py-3 focus:outline-none">Click to view discussions</button>
        </form>
    @else
        <comment-list :commentable='@json($commentable)' :user='@json(Auth::user())'></comment-list>
    @endguest
</div>
@endsection

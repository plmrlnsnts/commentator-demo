@extends('layouts.app')

@section('content')
<div>
    @guest
        <form class="text-center py-24" action="{{ route('login') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $user->email }}">
            <input type="hidden" name="password" value="password">
            <div class="mb-8"><img src="{{ asset('placeholder.svg') }}" class="inline-block w-32" alt=""></div>
            <button type="submit" class="border rounded font-medium px-4 py-3 focus:outline-none">Login to view discussions</button>
        </form>
    @else
        <comment-list :commentable='@json($commentable)' :user='@json(Auth::user())'></comment-list>
    @endguest
</div>
@endsection

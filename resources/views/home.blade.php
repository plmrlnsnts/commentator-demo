@extends('layouts.app')

@section('content')
<div>
    <comment-list :commentable='@json($commentable)' :user='@json(Auth::user())'></comment-list>
</div>
@endsection

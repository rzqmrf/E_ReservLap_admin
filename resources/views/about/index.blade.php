@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>About List</h1>
        <a href="{{ route('about.create') }}">Create new</a>
        <ul>
            @foreach($abouts as $item)
                <li>
                    <a href="{{ route('about.show', $item) }}">{{ $item->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

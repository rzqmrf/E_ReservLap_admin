@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $about->title }}</h1>
        <div>
            {!! nl2br(e($about->content)) !!}
        </div>
        <p><a href="{{ route('about.index') }}">Back to list</a></p>
    </div>
@endsection

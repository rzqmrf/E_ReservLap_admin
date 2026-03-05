@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit About</h1>
        <form action="{{ route('about.update', $about) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $about->title) }}">
            </div>
            <div>
                <label>Content</label>
                <textarea name="content">{{ old('content', $about->content) }}</textarea>
            </div>
            <button type="submit">Update</button>
        </form>
    </div>
@endsection

@extends('layouts.app')
@section('title', 'Contact')
@section('content')
<h1>Contact Us</h1>

<form>
    <input type="text" placeholder="Nama">
    <input type="email" placeholder="Email">
    <textarea placeholder="Pesan"></textarea>
    <button type="submit">Kirim</button>
</form>
@endsection

@extends('layouts.app')

@section('title', 'Cetak Buku Induk')

@section('content')

<div class="bg-white text-black p-6 rounded-lg">

    <h1 class="text-xl font-bold mb-4">Cetak Buku Induk</h1>

    <button onclick="window.print()"
        class="bg-brandAccent text-white px-4 py-2 rounded-lg">
        Print
    </button>

</div>

@endsection

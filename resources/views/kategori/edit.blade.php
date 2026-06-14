@extends('layouts.app')

@section('content')

<h2>Edit Kategori</h2>

<form action="{{ route('kategori.update',$kategori->id) }}"
      method="POST">

@csrf
@method('PUT')

<input
type="text"
name="nama_kategori"
value="{{ $kategori->nama_kategori }}"
class="form-control">

<br>

<button
type="submit"
class="btn btn-neon">

Simpan

</button>

</form>

@endsection
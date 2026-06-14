@extends('layouts.app')

@section('content')

<div class="card-modern">

<h2>

Tambah Kategori

</h2>

<form
action="/kategori"
method="POST">

@csrf

<label>

Nama Kategori

</label>

<input
type="text"
name="nama_kategori"
class="form-control">

<br>

<button
class="btn btn-neon">

Simpan

</button>

</form>

</div>

@endsection
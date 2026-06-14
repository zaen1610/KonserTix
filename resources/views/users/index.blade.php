@extends('layouts.app')

@section('title','Data Pengguna')

@section('content')

<div class="card-dark">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="text-white">
            <i class="bi bi-people-fill"></i>
            Data Pengguna
        </h4>

    </div>

    <table class="table table-dark table-hover">

        <thead>

            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
            </tr>

        </thead>

        <tbody>

        @foreach($users as $user)

            <tr>

                <td>{{ $user->id }}</td>

                <td>{{ $user->name }}</td>

                <td>{{ $user->email }}</td>

                <td>{{ $user->role }}</td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection
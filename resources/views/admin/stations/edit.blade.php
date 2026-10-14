@extends('layouts.admin')

@section('title', 'Modifier — '.$station->name)
@section('page-title', 'Modifier la station')

@section('content')
    <div class="card p-6 sm:p-8 max-w-4xl">
        <form method="POST" action="{{ route('admin.stations.update', $station) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.stations._form')
        </form>
    </div>
@endsection

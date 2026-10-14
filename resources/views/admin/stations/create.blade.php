@extends('layouts.admin')

@section('title', 'Nouvelle station')
@section('page-title', 'Ajouter une station')

@section('content')
    <div class="card p-6 sm:p-8 max-w-4xl">
        <form method="POST" action="{{ route('admin.stations.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.stations._form')
        </form>
    </div>
@endsection

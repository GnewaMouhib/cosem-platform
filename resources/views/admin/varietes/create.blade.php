@extends('layouts.admin')

@section('title', 'Nouvelle variété')
@section('page-title', 'Ajouter une variété')

@section('content')
    <div class="card p-6 sm:p-8 max-w-4xl">
        <form method="POST" action="{{ route('admin.cereales.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.varietes._form')
        </form>
    </div>
@endsection

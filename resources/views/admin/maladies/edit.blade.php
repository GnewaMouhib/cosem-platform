@extends('layouts.admin')

@section('title', 'Modifier — '.$disease->name)
@section('page-title', 'Modifier la maladie')

@section('content')
    <div class="card p-6 sm:p-8 max-w-4xl">
        <form method="POST" action="{{ route('admin.maladies.update', $disease) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.maladies._form')
        </form>
    </div>
@endsection

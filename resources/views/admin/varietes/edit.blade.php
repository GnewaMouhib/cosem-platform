@extends('layouts.admin')

@section('title', 'Modifier — '.$cereal->name)
@section('page-title', 'Modifier la variété')

@section('content')
    <div class="card p-6 sm:p-8 max-w-4xl">
        <form method="POST" action="{{ route('admin.cereales.update', $cereal) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.varietes._form')
        </form>
    </div>
@endsection

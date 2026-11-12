@extends('layouts.admin')

@section('title', 'Modifier — '.$pulse->name)
@section('page-title', 'Modifier la légumineuse')

@section('content')
    <div class="card p-6 sm:p-8 max-w-4xl">
        <form method="POST" action="{{ route('admin.legumineuses.update', $pulse) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.legumineuses._form')
        </form>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Nouvelle légumineuse')
@section('page-title', 'Ajouter une légumineuse')

@section('content')
    <div class="card p-6 sm:p-8 max-w-4xl">
        <form method="POST" action="{{ route('admin.legumineuses.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.legumineuses._form')
        </form>
    </div>
@endsection

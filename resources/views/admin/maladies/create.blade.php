@extends('layouts.admin')

@section('title', 'Nouvelle maladie')
@section('page-title', 'Ajouter une maladie')

@section('content')
    <div class="card p-6 sm:p-8 max-w-4xl">
        <form method="POST" action="{{ route('admin.maladies.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.maladies._form')
        </form>
    </div>
@endsection

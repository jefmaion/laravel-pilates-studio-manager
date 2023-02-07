@extends('layouts.main')

@section('content')

<form action="{{ route('instructor.update', $instructor) }}" method="post">
    @method('put')
    @csrf
    @include('instructor.form', ['title' => 'Editar Professor']);
</form>

@endsection
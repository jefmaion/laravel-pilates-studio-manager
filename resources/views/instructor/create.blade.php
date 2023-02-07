@extends('layouts.main')

@section('content')
<form action="{{ route('instructor.store') }}" method="post">
    @csrf
    @include('instructor.form', ['title' => 'Novo Professor']);
</form>



@endsection
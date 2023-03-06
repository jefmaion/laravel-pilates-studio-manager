@extends('layouts.main')

@section('breadcrumb')
<nav aria-label="breadcrumb mr-0">
    <ol class="breadcrumb mt-0">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('student.index') }}">Professores</a></li>
      <li class="breadcrumb-item active" aria-current="page">Cadastrar Novo Professor</li>
    </ol>
  </nav>
@endsection

@section('content')
<form action="{{ route('instructor.store') }}" method="post">
    @csrf
    @include('instructor.form', ['title' => 'Novo Professor']);
</form>



@endsection
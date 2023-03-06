@extends('layouts.main')

@section('breadcrumb')
<nav aria-label="breadcrumb mr-0">
    <ol class="breadcrumb mt-0">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('instructor.index') }}">Professores</a></li>
      <li class="breadcrumb-item active" aria-current="page">Editar Professor</li>
    </ol>
  </nav>
@endsection

@section('content')

<form action="{{ route('instructor.update', $instructor) }}" method="post">
    @method('put')
    @csrf
    @include('instructor.form', ['title' => 'Editar Professor - ' . $instructor->user->name ]);
</form>

@endsection
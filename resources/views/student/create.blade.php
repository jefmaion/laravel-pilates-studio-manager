@extends('layouts.main')


@section('breadcrumb')
<nav aria-label="breadcrumb mr-0">
    <ol class="breadcrumb mt-0">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('student.index') }}">Alunos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Cadastrar Novo Aluno</li>
    </ol>
  </nav>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Novo Aluno
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('student.store') }}" method="post">
                    @csrf
                    @include('student.form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
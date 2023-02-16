@extends('layouts.main')

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
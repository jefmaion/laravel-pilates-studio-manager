@extends('layouts.main')

@section('breadcrumb')
<nav aria-label="breadcrumb ml-0">
    <ol class="breadcrumb mt-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('plan.index') }}">Planos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar Plano - {{ $plan->name}} </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Editar Plano
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('plan.update', $plan) }}" method="post">
                    @method('put')
                    @csrf
                    @include('plan.form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
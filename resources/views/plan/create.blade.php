@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Novo Plano
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('plan.store') }}" method="post">
                    @csrf
                    @include('plan.form')
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
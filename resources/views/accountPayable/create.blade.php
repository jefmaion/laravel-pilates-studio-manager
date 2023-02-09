@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Nova Conta a Receber
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('payable.store') }}" method="post">
                    @csrf
                    @include('accountPayable.form')
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
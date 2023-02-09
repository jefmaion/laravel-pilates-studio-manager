@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Receber
                </h4>
            </div>
            <div class="card-body">


                <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                    <li class="media">
                        <figure class="avatar mr-2 avatar-xl mr-4">
                            <img src="{{ imageProfile($account->student->user->image) }}" alt="...">
    
                        </figure>
                        <div class="media-body">
    
    
                            <div class="media-title mb-1">
                                <a href="{{ route('registration.show', $account->registration_id) }}">
                                    <h5> {{ $account->student->user->name }}
    
                                        <span class="text-muted">
                                         <small>
                                        <i class="fa fa-phone"></i>
                                        {{ $account->student->user->phone_wpp }}
                                    </small>
                                </span> </h5>
                                </a>
                                {{-- <span class="badge badge-pill p-1 badge-{{ $account->classType }}">{{ $account->type}}</span> --}}
                            </div>
    
                            <div class="">
                                <div class="mb-2">
                                    
                                    
                                </div>
    
                            </div>
    
                          
                        </div>
                    </li>
    
                </ul>



                <form action="{{ route('payable.update', $account) }}" method="post">
                    @method('put')
                    @csrf
                    <div class="row">

                        <input type="hidden" name="status" value="1">

                        <div class="col-9 form-group">
                            <label>Descrição</label>
                            <x-form-input name="name" value="{{ $account->description }}" />
                        </div>
                    
                        <div class="col-3 form-group">
                            <label>Data de Vencimento</label>
                            <x-form-input type="date" name="duration" value="{{ $account->due_date }}" />
                        </div>
                    
                        <div class="col-2 form-group">
                            <label>Valor</label>
                            <x-form-input name="value" class="money" value="{{ USD_BRL($account->initial_value) }}" />
                        </div>

                        <div class="col-2 form-group">
                            <label>Multa + mora</label>
                            <x-form-input name="duration" value="{{ USD_BRL($account->fee_value) }}" />
                        </div>
                    
                        <div class="col-5 form-group">
                            <label>Valor Final</label>
                            <x-form-input name="value" class="money" value="{{ USD_BRL($account->value) }}" />
                        </div>

                        <div class="col-3 form-group">
                            <label>Data de Pagamento</label>
                            <x-form-input type="date" name="pay_date" value="{{ $account->pay_date }}" />
                        </div>

                        <div class="col-3 form-group">
                            <label>Dias Atraso</label>
                            <x-form-input type="number" name="duration" value="{{ $account->delay_days }}" />
                        </div>

                        
                    
                        
                    
                    </div>
                    
                    <a name="" id="" class="btn btn-secondary" href="{{ route('payable.index') }}" role="button">
                        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                        Voltar
                    </a>
                    
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle"></i>
                        Receber Pagamento
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
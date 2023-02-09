@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-4">
        <div class="card">

            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Contas a Receber - Detalhes
                </h4>
            </div>


            <div class="card-body">

                <h5>{{ $account->description }}</h5>

                <div class="my-3">
                    {!! $account->statusLabel !!}
                </div>

                <h4 class="text-info">R$ {{ USD_BRL($account->value) }}</h4>

                <p><small>Criado em {{ $account->created_at->diffForHumans() }} | Atualizado em {{ $account->updated_at->diffForHumans() }}</small></p>

                

                <hr>

                <a name="" id="" class="btn btn-secondary" href="{{ route('payable.index') }}" role="button">
                    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                    Voltar

                </a>


                <div class="dropdown d-inline">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu" x-placement="bottom-start">

                        <a class="dropdown-item has-icon" href="{{ route('payable.receive', $account) }}">
                            <i class="fas fa-money-bill    "></i> Receber
                        </a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item has-icon" href="{{ route('payable.edit', $account) }}">
                            <i class="fas fa-edit    "></i> Editar Conta
                        </a>
                        <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-target="#basicModal">
                            <i class="fas fa-trash    "></i> Excluir Conta
                        </a>
                    </div>
                </div>






            </div>


        </div>
    </div>
</div>

@endsection

@section('outbody')
<!-- Modal -->
<div class="modal fade show" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja excluir esse registro?
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form action="{{ route('payable.destroy', $account) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"> <i class="fas fa-trash    "></i> Excluir</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times    "></i> Fechar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.main')

@section('content')

<h4 class="mb-4">Exercício - Detalhes</h4>


<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">

                <h3><strong>{{ $exercice->name }}</strong></h3>
                <p>{{ $exercice->description }}</p>

                <p><small>Criado em {{ $exercice->created_at->diffForHumans() }} | Atualizado em {{ $exercice->updated_at->diffForHumans() }}</small></p>

                {{-- <div class="row">
                    <div class="col-2">
                        <div class="">
                            <p class="clearfix">
                                <span class="float-left">Duração do Plano</span>
                                <span class="float-right text-muted">{{ $exercice->duration }} Mês(es)</span>
                            </p>
                            <p class="clearfix">
                                <span class="float-left">Aulas por semana</span>
                                <span class="float-right text-muted">{{ $exercice->class_per_week }}</span>
                            </p>
                            <p class="clearfix">
                                <span class="float-left">Valor</span>
                                <span class="float-right text-muted">R$ {{ USD_BRL($exercice->value) }}</span>
                            </p>


        
                        </div>
                    </div>
                </div> --}}

                <hr>

                <a name="" id="" class="btn btn-secondary" href="{{ route('exercice.index') }}" role="button">
                    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                    Voltar
                </a>
                </a>

                <div class="dropdown d-inline">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu" x-placement="bottom-start">
                        <a class="dropdown-item has-icon" href="{{ route('exercice.edit', $exercice) }}">
                            <i class="fas fa-edit    "></i> Editar Exercício
                        </a>
                        <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-target="#basicModal">
                            <i class="fas fa-trash    "></i> Excluir Exercício
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
                <form action="{{ route('exercice.destroy', $exercice) }}" method="post">
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
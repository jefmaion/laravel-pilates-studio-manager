@extends('layouts.main')


@section('breadcrumb')
<nav aria-label="breadcrumb mr-0">
    <ol class="breadcrumb mt-0">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('exercice.index') }}">Exercícios</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $exercice->name }}</li>
    </ol>
  </nav>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">

                <h3><strong>{{ $exercice->name }}</strong></h3>
                <p>{{ $exercice->description }}</p>

                <p><small>Criado em {{ $exercice->created_at->diffForHumans() }} | Atualizado em {{ $exercice->updated_at->diffForHumans() }}</small></p>

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
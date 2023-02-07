@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-4">


        <div class="card author-box">
            <div class="card-body">
                <div class="author-box-left">
                    <img alt="image" src="{{ imageProfile($instructor->user->image) }}"
                        class="rounded-circle author-box-picture">
                    <div class="clearfix"></div>

                    <a href="{{ route('instructor.profile', $instructor) }}" class="btn btn-light mt-3 follow-btn">
                        Trocar Foto
                    </a>

                </div>
                <div class="author-box-details">

                    <div class="author-box-name">
                        <a href="#">{{ $instructor->user->name }}</a>
                    </div>

                    <div class="author-box-job">
                        <div>Cadastrado {{ $instructor->created_at->diffForHumans() }}</div>
                        <div>Atualizado {{ $instructor->updated_at->diffForHumans() }}</div>
                    </div>

                    <div class="author-box-description">

                        <div>
                            <strong><i class="fa fa-phone" aria-hidden="true"></i></strong>
                            {{ $instructor->user->phone_wpp }} | {{ $instructor->user->phone2 }}
                        </div>

                        <div>
                            <strong><i class="fa fa-phone" aria-hidden="true"></i></strong>
                            {{ $instructor->user->email }}
                        </div>

                    </div>

                </div>

                <br>

                <hr>

                <a name="" id="" class="btn btn-secondary" href="{{ route('instructor.index') }}" role="button">
                    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                    Voltar
                </a>

                <div class="dropdown d-inline">

                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>

                    <div class="dropdown-menu" x-placement="bottom-start">

                        <a class="dropdown-item has-icon" href="{{ route('instructor.profile', $instructor) }}">
                            <i class="fas fa-image    "></i> Alterar Foto de Perfil
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item has-icon" href="{{ route('instructor.edit', $instructor) }}">
                            <i class="fas fa-edit    "></i> Editar Professor
                        </a>

                        <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-target="#basicModal">
                            <i class="fas fa-trash    "></i> Excluir Professor
                        </a>

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
                        <form action="{{ route('instructor.destroy', $instructor) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"> <i class="fas fa-trash    "></i>
                                Excluir</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i
                                    class="fas fa-times    "></i> Fechar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        {{-- <div class="modal fade show" id="modal-cancel-registration" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-modal="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Deseja cancelar essa matrícula?
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <form action="{{ route('registration.destroy', [$instructor, $instructor->registration]) }}"
                            method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"> <i class="fas fa-trash    "></i>
                                Cancelar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i
                                    class="fas fa-times    "></i> Fechar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}

        @endsection
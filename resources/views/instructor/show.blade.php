@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-3">
        <x-user-card title="Professor"   :user="$instructor->user">


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

                    <a class="dropdown-item has-icon" href="#" id="change-photo">
                        <i class="fas fa-image    "></i> Alterar Foto de Perfil
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item has-icon" href="{{ route('instructor.edit', $instructor) }}">
                        <i class="fas fa-edit    "></i> Editar Professor
                    </a>

                    {{-- <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-target="#basicModal">
                        <i class="fas fa-trash    "></i> Excluir Professor
                    </a> --}}

                    <x-modal-delete route="{{ route('instructor.destroy', $instructor) }}" message="Deseja excluir esse professor?">
                        <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-target="#basicModal">
                            <i class="fas fa-trash    "></i> Excluir Professor
                        </a>
                    </x-modal-delete>

                </div>
            </div>
        </x-user-card>
    </div>

    <div class="col d-flex">

        <div class="card flex-fill">
            <div class="card-header">
                <h4>
                    <i class="fa fa-users" aria-hidden="true"></i>
                    Dados Cadastrais
                </h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-6 b-r">
                        <strong>Endereço</strong>
                        <br>
                        <p class="text-muted"> {{ $instructor->user->address }}, {{ $instructor->user->number }}</p>
                    </div>
                    <div class="col-md-3 col-6 b-r">
                        <strong>Complemento</strong>
                        <br>
                        <p class="text-muted">{{ $instructor->user->address }}</p>
                    </div>
                    <div class="col-md-3 col-6 b-r">
                        <strong>CEP</strong>
                        <br>
                        <p class="text-muted">{{ $instructor->user->zipcode }}</p>
                    </div>
                    <div class="col-md-3 col-6">
                        <strong>Bairro</strong>
                        <br>
                        <p class="text-muted">{{ $instructor->user->district }}</p>
                    </div>
                    <div class="col-md-3 col-6">
                        <strong>Cidade</strong>
                        <br>
                        <p class="text-muted">{{ $instructor->user->city }}</p>
                    </div>

                    <div class="col-md-3 col-6">
                        <strong>Estado</strong>
                        <br>
                        <p class="text-muted">{{ $instructor->user->state }}</p>
                    </div>

                    <div class="col-md-3 col-6">
                        <strong>Telefone WhatsApp</strong>
                        <br>
                        <p class="text-muted">{{ $instructor->user->phone_wpp }}</p>
                    </div>

                    <div class="col-md-3 col-6">
                        <strong>Telefone Recado</strong>
                        <br>
                        <p class="text-muted">{{ $instructor->user->phone2 }}</p>
                    </div>


                    <div class="col-md-6 col-6">
                        <strong>Formação Profissional</strong>
                        <br>
                        <p class="text-muted">{{ $instructor->profession }}</p>
                    </div>

                    <div class="col-md-6 col-6">
                        <strong>Registro</strong>
                        <br>
                        <p class="text-muted">{{ $instructor->profession_document }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="card">
    <div class="card-header">
        <h4>
            <i class="fa fa-users" aria-hidden="true"></i>
            Informações
        </h4>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"aria-selected="true">Evoluções</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Matrículas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Aulas</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#contact3" role="tab" aria-controls="contact3" aria-selected="false">Mensalidades</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                
               
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Ano</th>
                            <th>Status</th>
                            <th>Dia</th>
                            <th>Hora</th>
                            <th>Comentários</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($instructor->classes as $class)
                        <tr>
                            <td scope="row">{{ date('Y', strtotime($class->created_at)) }}</td>
                            <td>{!!$class->statusClass!!}</td>
                            <td>{{ $class->date }}</td>
                            <td>{{ $class->time }}</td>
                            <td>{{ $class->comments }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@include('user.image-profile-upload', ['route' => route('instructor.profile.store', $instructor)])

@section('css')
    @include('layouts.plugins.datatables', ['file' => 'css'])
@endsection

@section('scripts')
    @include('layouts.plugins.datatables', ['file' => 'js'])
    <script src="{{ asset('js/datatables.config.js') }}"></script>
@endsection    
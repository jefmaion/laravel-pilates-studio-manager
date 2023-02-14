@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-4">


        <div class="card author-box">
            <div class="card-body">
                <div class="author-box-left">
                    <img alt="image" src="{{ imageProfile($student->user->image) }}"
                        class="rounded-circle author-box-picture">
                    <div class="clearfix"></div>

                    <a href="{{ route('student.profile', $student) }}" class="btn btn-light mt-3 follow-btn">
                        Trocar Foto
                    </a>

                </div>
                <div class="author-box-details">

                    <div class="author-box-name">
                        <a href="#">{{ $student->user->name }}</a>
                    </div>

                    <div class="author-box-job">
                        <div>Cadastrado {{ $student->created_at->diffForHumans() }}</div>
                        <div>Atualizado {{ $student->updated_at->diffForHumans() }}</div>
                    </div>

                    <div class="author-box-description">

                        <div>
                            <strong><i class="fa fa-phone" aria-hidden="true"></i></strong>
                            {{ $student->user->phone_wpp }} | {{ $student->user->phone2 }}
                        </div>

                        <div>
                            <strong><i class="fa fa-phone" aria-hidden="true"></i></strong>
                            {{ $student->user->email }}
                        </div>

                    </div>

                </div>

                <br>

                <hr>

                <a name="" id="" class="btn btn-secondary" href="{{ route('student.index') }}" role="button">
                    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                    Voltar
                </a>

                <div class="dropdown d-inline">

                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>

                    <div class="dropdown-menu" x-placement="bottom-start">

                        <a class="dropdown-item has-icon" href="{{ route('student.profile', $student) }}">
                            <i class="fas fa-image    "></i> Alterar Foto de Perfil
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item has-icon" href="{{ route('student.edit', $student) }}">
                            <i class="fas fa-edit    "></i> Editar Aluno
                        </a>

                        <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-target="#basicModal">
                            <i class="fas fa-trash    "></i> Excluir Aluno
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">

        <div class="card">
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
                        <p class="text-muted"> {{ $student->user->address }}, {{ $student->user->number }}</p>
                    </div>
                    <div class="col-md-3 col-6 b-r">
                        <strong>Complemento</strong>
                        <br>
                        <p class="text-muted">{{ $student->user->address }}</p>
                    </div>
                    <div class="col-md-3 col-6 b-r">
                        <strong>CEP</strong>
                        <br>
                        <p class="text-muted">{{ $student->user->zipcode }}</p>
                    </div>
                    <div class="col-md-3 col-6">
                        <strong>Bairro</strong>
                        <br>
                        <p class="text-muted">{{ $student->user->district }}</p>
                    </div>
                    <div class="col-md-3 col-6">
                        <strong>Cidade</strong>
                        <br>
                        <p class="text-muted">{{ $student->user->city }}</p>
                    </div>

                    <div class="col-md-3 col-6">
                        <strong>Estado</strong>
                        <br>
                        <p class="text-muted">{{ $student->user->state }}</p>
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ano</th>
                            <th>Status</th>
                            <th>Plano</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->registrations as $registration)
                        <tr>
                            <td scope="row">{{ date('Y', strtotime($registration->created_at)) }}</td>
                            <td>{!!$registration->statusRegistration!!}</td>
                            <td>{{ $registration->plan->name }}</td>
                            <td>{{ $registration->final_value }}</td>
                            
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
               
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ano</th>
                            <th>Status</th>
                            <th>Dia</th>
                            <th>Hora</th>
                            <th>Instrutor Agendado</th>
                            <th>Instrutor Efetivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->classes as $class)
                        <tr>
                            <td scope="row">{{ date('Y', strtotime($class->created_at)) }}</td>
                            <td>{!!$class->statusClass!!}</td>
                            <td>{{ $class->date }}</td>
                            <td>{{ $class->time }}</td>
                            <td>{{ $class->scheduledInstructor->user->name }}</td>
                            <td>{{ $class->instructor->user->name }}</td>
                            
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
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
                <form action="{{ route('student.destroy', $student) }}" method="post">
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



@endsection
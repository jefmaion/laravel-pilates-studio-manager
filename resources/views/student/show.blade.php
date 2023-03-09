@extends('layouts.main')

@section('breadcrumb')
<nav aria-label="breadcrumb ml-0">
    <ol class="breadcrumb mt-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('student.index') }}">Alunos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dados do Aluno - {{ $student->user->name }} </li>
    </ol>
</nav>
@endsection

@section('content')


<div class="row">
    <div class="col-4">

        <x-user-card class="card-secondary" title="Aluno" :user="$student->user">

            <div class="dropdown d-inline">

                <button class="btn btn-primary btn-bslock dropdown-toggle" type="button" id="dropdownMenuButton2"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ações
                </button>

                <div class="dropdown-menu" x-placement="bottom-start">

                    <a class="dropdown-item has-icon" href="#" id="change-photo">
                        <i class="fas fa-image    "></i> Alterar Foto de Perfil
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item has-icon" href="{{ route('student.edit', $student) }}">
                        <i class="fas fa-edit    "></i> Editar Aluno
                    </a>

                    <x-modal-delete route="{{ route('student.destroy', $student) }}">
                        <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-target="#basicModal">
                            <i class="fas fa-trash    "></i> Excluir Aluno
                        </a>
                    </x-modal-delete>

                </div>
            </div>
        </x-user-card>

        <div class="card card-secondary">
            <div class="card-header">
                <h4>Dados Cadastrais</h4>
            </div>
            <div class="card-body">
                <div class="py-4">
                    <p class="clearfix">
                        <span class="float-left">
                            Endereço
                        </span>
                        <span class="float-right text-muted">
                            {{ $student->user->address }},
                            {{ $student->user->number }}
                            {{ $student->user->complement }}
                        </span>
                    </p>

                    <p class="clearfix">
                        <span class="float-left">
                            Bairro
                        </span>
                        <span class="float-right text-muted">
                            {{ $student->user->district }} - 
                            {{ $student->user->city }} / {{ $student->user->state }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left">
                            Telefones
                        </span>
                        <span class="float-right text-muted">
                            {{ $student->user->phone_wpp }} / {{ $student->user->phone2 }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left">
                            Email
                        </span>
                        <span class="float-right text-muted">
                            {{ $student->user->email }}
                        </span>
                    </p>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="col-8 d-flex">

        <div class="card flex-fill card-secondary">
            <div class="card-header">
                <h4>
                    <i class="fa fa-users" aria-hidden="true"></i>
                    Histórico
                </h4>
            </div>
            <div class="card-body">

                <ul class="nav nav-tabs nav-justsified" id="myTab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                            Evoluções
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                            Matrículas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                            Aulas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#contact3" role="tab" aria-controls="contact3" aria-selected="false"> 
                            Mensalidades
                        </a>
                    </li>

                </ul>

                <div class="tab-content" id="myTabContent">

                    {{-- Evoluções --}}
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <x-data-table>
                            <thead>
                                <tr>
                                    <th>Ano</th>
                                    <th>Data da Aula</th>
                                    <th>Professor Avaliador</th>
                                    <th>Data de criação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->evolutions as $evolution)
                                <tr>
                                    <td scope="row">{{ date('Y', strtotime($evolution->created_at)) }}</td>
                                    <td>{{ dateDMY($evolution->date) }}</td>
                                    <td>{{ $evolution->instructor->user->name }}</td>
                                    <td>{{ dateDMY($evolution->created_at) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </x-data-table>
                    </div>

                    {{-- Matrículas --}}
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <x-data-table>
                            <thead>
                                <tr>
                                    <th>Ano</th>
                                    <th>Plano</th>
                                    <th>Início</th>
                                    <th>Fim</th>
                                    <th>Valor</th>
                                    <th>Nº Aulas</th>
                                    <th>Nº Presenças</th>
                                    <th>Nº Faltas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->registrations()->orderBy('id', 'desc')->get() as $registration)
                                <tr>
                                    <td scope="row">{{ date('Y', strtotime($registration->created_at)) }}</td>
                                    <td>{{ $registration->plan->name }}</td>
                                    <td>{{ dateDMY($registration->start) }}</td>
                                    <td>{{ dateDMY($registration->end) }}</td>
                                    <td>R$ {{ USD_BRL($registration->final_value) }}</td>
                                    <td>{{ $registration->classes->count() }}</td>
                                    <td>{{ $registration->presenceClasses }}</td>
                                    <td>{{ $registration->absenseClasses }}</td>
                                    <td>{!!$registration->statusRegistration!!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </x-data-table>
                    </div>

                    {{-- Aulas --}}
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <x-data-table>
                            <thead>
                                <tr>
                                    <th>Ano</th>
                                    <th>Dia</th>
                                    <th>Hora</th>
                                    <th>Instrutor Agendado</th>
                                    <th>Instrutor Efetivo</th>
                                    <th>Status</th>
                                    <th>Comentários</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->classes()->orderBy('id', 'desc')->get() as $class)
                                <tr>
                                    <td scope="row">{{ date('Y', strtotime($class->created_at)) }}</td>
                                    <td>{{ $class->date }}</td>
                                    <td>{{ dateDMY($class->time) }}</td>
                                    <td>{{ $class->scheduledInstructor->user->name }}</td>
                                    <td>{{ $class->instructor->user->name }}</td>
                                    <td>{!!$class->statusClass!!}</td>
                                    <td>{{ $class->comments }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </x-data-table>
                    </div>

                    {{-- Mensalidades --}}
                    <div class="tab-pane fade" id="contact3" role="tabpanel" aria-labelledby="contact-tab">
                        <x-data-table>
                            <thead class="">
                                <tr>
                                    <th>Ano</th>
                                    <th>Data Vencimento</th>
                                    <th>Data Pagamento</th>
                                    <th>Pago em</th>
                                    <th>Valor Inicial</th>
                                    <th>Valor Pago</th>
                                    <th>Status</th>
                                    <th>Observações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->installments()->orderBy('id', 'desc')->get() as $inst)
                                <tr>
                                    <td>{{ date('Y', strtotime($inst->due_date)) }}</td>
                                    <td>{{ date('d/m/Y', strtotime($inst->due_date)) }}</td>
                                    <td>{{ dateDMY($inst->pay_date) }}</td>
                                    <td>{{ $inst->paymentMethod->name }}</td>
                                    <td>R$ {{ USD_BRL($inst->initial_value) }}</td>
                                    <td>R$ {{ USD_BRL($inst->value) }}</td>
                                    <td>{!! $inst->status_label !!}</td>
                                    <td>{{ $inst->comments }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </x-data-table>
                    </div>
                </div>
            </div>
        </div>


        

    </div>
</div>


<a name="" id="" class="btn btn-secondary" href="{{ route('student.index') }}" role="button">
    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
    Voltar
</a>

@include('user.image-profile-upload', ['route' => route('student.profile.store', $student)])

@endsection

@section('css')
@include('layouts.plugins.datatables', ['file' => 'css'])
@endsection

@section('scripts')
@include('layouts.plugins.datatables', ['file' => 'js'])
<script src="{{ asset('js/datatables.config.js') }}"></script>
@endsection
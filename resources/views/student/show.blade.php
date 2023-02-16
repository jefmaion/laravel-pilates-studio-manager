@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-3">

        <x-user-card title="Aluno"   :user="$student->user">
            

            <div class="dropdown d-inline">

                <button class="btn btn-primary btn-block dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

                    <x-modal-delete route="{{ route('student.destroy', $student) }}">
                        <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-target="#basicModal">
                            <i class="fas fa-trash    "></i> Excluir Aluno
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
            Histórico
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
                <table class="table table-sm table-striped datatables w-100">
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
                            <td>{{ dateDMY($evolution->classes->date) }}</td>
                            <td>{{ $evolution->instructor->user->name }}</td>
                            <td>{{ dateDMY($evolution->created_at) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table table-sm table-striped datatables w-100">
                    <thead>
                        <tr>
                            <th>Ano</th>
                            <th>Plano</th>
                            <th>Início</th>
                            <th>Fim</th>
                            <th>Valor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->registrations as $registration)
                        <tr>
                            <td scope="row">{{ date('Y', strtotime($registration->created_at)) }}</td>
                            <td>{{ $registration->plan->name }}</td>
                            <td>{{ dateDMY($registration->start) }}</td>
                            <td>{{ dateDMY($registration->end) }}</td>
                            <td>R$ {{ USD_BRL($registration->final_value) }}</td>
                            <td>{!!$registration->statusRegistration!!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <table class="table table-sm table-striped datatables w-100">
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
                        @foreach($student->classesFinished as $class)
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
                </table>
            </div>

            <div class="tab-pane fade" id="contact3" role="tabpanel" aria-labelledby="contact-tab">
                <table class="table table-sm table-striped datatables w-100" id="table-def" stylse="font-size:13px">
                    <thead class="">
                        <tr>
                            <th>Ano</th>
                            <th>Data Vencimento</th>
                            <th>Data Pagamento</th>
                            <th>Forma de Pagamento</th>
                            <th>Valor Inicial</th>
                            <th>Valor Pago</th>
                            <th>Status</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->installments as $inst)
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
                </table>
            </div>
        </div>
    </div>
</div>

<a name="" id="" class="btn btn-secondary" href="{{ route('student.index') }}" role="button">
    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
    Voltar
</a>

@endsection

@section('css')
    @include('layouts.plugins.datatables', ['file' => 'css'])
@endsection

@section('scripts')
    @include('layouts.plugins.datatables', ['file' => 'js'])
    <script src="{{ asset('js/datatables.config.js') }}"></script>
    <script>$(".datatables").dataTable({...config});</script>
@endsection    
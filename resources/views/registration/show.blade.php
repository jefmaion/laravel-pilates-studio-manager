@extends('layouts.main')

@section('breadcrumb')
<nav aria-label="breadcrumb mr-0">
    <ol class="breadcrumb mt-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('registration.index') }}">Matrículas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Matrícula de {{ $registration->student->user->name }}
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-lg-12 col-md-8 col-sm-12">
        <div class="card author-box">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    {{ $registration->student->user->name }}
                </h4>

                <div class="card-header-action">
                    <div class="dropdown">
                        <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" aria-expanded="false">Ações</a>
                        <div class="dropdown-menu dropdown-menu-right">



                            <a href="#" class="dropdown-item has-icon" data-toggle="modal" data-target="#modal-finish-registration"><i class="far fa-edit"></i> Finalizar Matrícula</a>
                            

                            @if($registration->canRenew)
                                <a href="#" class="dropdown-item has-icon" data-toggle="modal" data-target="#modal-re-enroll"><i class="fas fa-sync"></i> Renovar Matrícula</a>
                            @endif

                            <div class="dropdown-divider"></div>
                            
                            @if($registration->canCancel)
                                <a href="#" data-toggle="modal" data-target="#modal-cancel-registration" class="dropdown-item has-icon text-danger">
                                    <i class="fas fa-power-off"></i> Cancelar
                                    Matrícula
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="author-box-left">
                    <img alt="image" src="{{ imageProfile($registration->student->user->image) }}"
                        class="rounded-circle author-box-picture">
                    <div class="clearfix"></div>
                </div>
                <div class="author-box-details">
                    <div class="author-box-name">
                        <a href="{{ route('student.show', $registration->student) }}">{{$registration->student->user->name
                            }}</a>
                    </div>
                    <div class="author-box-description mt-0">
                        <div>
                            <strong><i class="fa fa-phone" aria-hidden="true"></i></strong>
                            {{ $registration->student->user->phone_wpp }}<span class="mx-1 text-light">/</span>
                            {{ $registration->student->user->phone2 }}
                        </div>
                        <div>
                            <i class="fas fa-caret-square-right"></i>
                            {{ $registration->plan->name }} <span class="mx-1 text-light">/</span> 
                            {{ date('d/m/y', strtotime($registration->start)) }} até {{ date('d/m/y', strtotime($registration->end)) }}
                        </div>
                        <div>
                            <i class="fas fa-caret-square-right"></i>
                            @foreach($registration->classWeek as $week)
                            {{ Config::get('application.weekdays')[$week->weekday] }} às 
                            {{ Config::get('application.class_time')[$week->time] }} 
                            @endforeach
                        </div>
                    </div>
                </div>
                <br>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link  active" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">
                            Grade de Aulas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                            aria-selected="true">
                            Mensalidades
                        </a>
                    </li>
                </ul>
                <div class="tab-content tab-bordsred" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                        <p class="my-4">
                            <a name="" id="" class="btn btn-success"
                                href="{{ route('registration.class.index', $registration) }}" role="button">
                                Editar Plano de Aulas
                            </a>
                        </p>

                        @if(!$registration->classes()->count())

                            <p>
                                Não existem aulas para essa matrícula. 
                                <a href="{{ route('registration.class.index', $registration) }}">Criar plano de aulas</a>
                            </p>

                        @else
                        <x-data-table>
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Hora</th>
                                    <th>Dia</th>
                                    <th>Instrutor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registration->classes as $class)
                                <tr>

                                    <td data-search="{{ date('d/m/Y', strtotime($class->date)) }}">
                                        {{ date('d/m/Y', strtotime($class->date)) }}
                                    </td>

                                    <td data-search="{{ $class->time }}">
                                        {{ $class->time }}
                                    </td>

                                    <td>
                                        {{ $class->weekdayName }}
                                    </td>

                                    <td>
                                        <figure class="avatar mr-2 avatar-sm"><img src="{{ imageProfile($class->instructor->user->image) }}"></figure>
                                        {{ $class->instructor->user->name }}
                                    </td>
                                    <td>
                                        {!! $class->statusClass !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </x-data-table>
                        @endif

                    </div>

                    <div class="tab-pane fade " id="home" role="tabpanel" aria-labelledby="home-tab">
                        <x-data-table>
                            <thead class="">
                                <tr>
                                    <th>Data</th>
                                    <th>Forma de Pagamento</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registration->installments as $inst)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($inst->due_date)) }}</td>
                                    <td>{{ $inst->paymentMethod->name }}</td>
                                    <td>R$ {{ USD_BRL($inst->value) }}</td>
                                    <td>
                                        @if($inst->isLate)
                                            <a href="{{ route('payable.receive', $inst) }}">
                                                {!! $inst->status_label !!}
                                            </a>
                                        @else
                                            {!! $inst->status_label !!}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </x-data-table>
                    </div>

                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<a name="" id="" class="btn btn-secondary" href="{{ url()->previous() }}" role="button">
    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
    Voltar
</a>

@endsection


@section('outbody')

<div class="modal fade show" id="modal-cancel-registration" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
    <form action="{{ route('registration.destroy', $registration) }}" method="post">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancelar Matrícula</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Deseja cancelar essa matrícula?</p>
                    <b>Motivo do cancelamento</b>
                    <x-form-input type="textarea" rows="3" name="cancellation_reason" />
                    <br>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="delete_installments" value="1">
                        <label class="custom-control-label" for="customCheck1">Excluir mensalidades em aberto</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck2" name="delete_scheduled_classes" value="1">
                        <label class="custom-control-label" for="customCheck2">Excluir aulas não realizadas</label>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i
                            class="fas fa-times    "></i> Fechar</button>
                    <button type="submit" class="btn btn-danger"> <i class="fas fa-trash    "></i> Cancelar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade show" id="modal-finish-registration" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
    <form action="{{ route('registration.update', $registration) }}" method="post">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Finalizar Matrícula</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Deseja finalizar e arquivar essa matrícula?</p>
                    <b>Comentários</b>
                    <x-form-input type="textarea" rows="3" name="cancellation_reason" />
                    <br>

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    @csrf
                    @method('PUT')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i
                            class="fas fa-times    "></i> Fechar</button>
                    <button type="submit" class="btn btn-primary"> <i class="fas fa-trash    "></i> Finalizar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade show" id="modal-re-enroll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modsal-sm" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-sync    "></i> Renovar Matrícula</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <p class="text-center">Manter o mesmo plano e os mesmos horários de aulas?</p>
            </div>

            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times    "></i>Não</button>
                <a name="" id="" class="btn btn-success" href="{{ route('registration.edit', $registration) }}" role="button">
                    <i class="fa fa-check-circle" aria-hidden="true"></i> Sim, Renovar
                </a>
            </div>
        </div>
    </div>
</div>



@section('css')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/page/datatables.js') }}"></script>
<script src="{{ asset('js/datatables.config.js') }}"></script>
<script>$(".datatables").dataTable({...config});</script>
@endsection
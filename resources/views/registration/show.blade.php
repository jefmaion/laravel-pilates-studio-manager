@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-12 col-lg-4 col-md-8 col-sm-12">
        <div class="card author-box">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Matrícula de {{ $registration->student->user->name }}
                </h4>
            </div>
            <div class="card-body">
                <div class="author-box-left">
                    <img alt="image" src="{{ imageProfile($registration->student->user->image) }}" class="rounded-circle author-box-picture">
                    <div class="clearfix"></div>
                </div>
                <div class="author-box-details">
                    <div class="author-box-name">
                        <a href="{{ route('student.show', $registration->student) }}">{{$registration->student->user->name }}</a>
                    </div>
                    <div class="author-box-description mt-0">
                        <div>
                            <strong><i class="fa fa-phone" aria-hidden="true"></i></strong>
                            {{ $registration->student->user->phone_wpp }}<span class="mx-1 text-light">/</span> 
                            {{ $registration->student->user->phone2 }}
                        </div>
                        <div>
                            <i class="fas fa-caret-square-right"></i>
                            {{ $registration->plan->name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card ">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Plano Atual
                </h4>
                <div class="card-header-action">

                </div>
            </div>

            <div class="card-body">

             
                <div class="pys-4">
                    <p class="clearfix">
                        <div class="row text-dark">
                            <div class="col">
                                <span class="float-left">
                                    Status da Matrícula
                                </span>
                            </div>
                            <div class="col">
                                <span class="float-right text-muted">
                                    {!!$registration->statusRegistration!!}
                                </span>
        
                            </div>
                        </div>
                    </p>


                    <p class="clearfix">

                        <div class="row text-dark">
                            <div class="col">
                                <span class="float-left">
                                    Plano
                                </span>
                            </div>
                            <div class="col">
                                <span class="float-right text-muted">
                                    {{ $registration->plan->name }}
                                </span>
                            </div>
                        </div>

                        
                        
                    </p>

                    <p class="clearfix">
                        <div class="row text-dark">
                            <div class="col">
                                <span class="float-left">
                                    Vigência
                                </span>
                            </div>
                            <div class="col">
                                <span class="float-right text-muted">
                                    {{ date('d/m/y', strtotime($registration->start)) }} até {{ date('d/m/y',
                                    strtotime($registration->end)) }}
                                </span>
                            </div>
                        </div>

                       
                     
                    </p>

                    <p class="clearfix">
                        <div class="row text-dark">
                            <div class="col">
                                <span class="float-left ">
                                    Aulas
                                </span>
                            </div>
                            <div class="col">
                                <span class="float-right text-muted text-right">

                                    @if($registration->classWeek()->count() == 0)

                                    <a href="{{ route('registration.class.index', $registration) }}" class="badge badge-warning">Adicionar Aulas</a>
                                    @endif


                                    @foreach($registration->classWeek as $week)
                                    <div>{{ Config::get('application.weekdays')[$week->weekday] }} às {{ Config::get('application.class_time')[$week->time] }}</div>
                                    @endforeach
                                 </span>
                            </div>
                        </div>
                    </p>
                    

                    @if($registration->status == 1)
                    <p class="clearfix">
                        <div class="row text-dark">
                            <div class="col">
                                <span class="float-left">
                                    Renovação
                                </span>
                            </div>
                            <div class="col">
                                <span class="float-right text-muted">
                                    {!! $registration->renewPeriod !!}
                                </span>
                            </div>
                        </div>
                        
                    </p>
                    
                    @endif

                    @if($registration->status == 0)

                    @if($registration->cancellation_reason)
                    <p class="clearfix">
                        <div class="row text-dark">
                            <div class="col">
                                <span class="float-left">
                                    Motivo do cancelamento
                                </span>
                            </div>
                            <div class="col">
                                <span class="float-right text-muted">
                                    {{ $registration->cancellation_reason }}
                                </span>
                            </div>
                        </div>
                        
                    </p>
                    
                    
                    @endif
                    <p class="clearfix">
                        <div class="row text-dark">
                            <div class="col">
                                <span class="float-left">
                                    Data do cancelamento
                                </span>
                            </div>
                            <div class="col">
                                <span class="float-right text-muted">
                                    {{ date('d/m/Y', strtotime($registration->cancellation_date)) }}
                                </span>
                            </div>
                        </div>
                    </p>
                    @endif

                </div>

                @if($registration->canCancel)
                    <a name="" id="" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal-cancel-registration" href="#" role="button">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Cancelar Matrícula
                    </a>
                @endif

                @if($registration->canRenew)
                        <a name="" id="" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-re-enroll" href="#">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            Renovar Matrícula
                        </a>
                    @endif

            </div>
        </div>


    </div>

    <div class="col-12 col-lg-8 col-sm-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Informações da Matrícula
                </h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link  active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                            Grade de Aulas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                            Mensalidades
                        </a>
                    </li>
                </ul>
                <div class="tab-content tab-bordsred" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                        <p class="my-4">
                            <a name="" id="" class="btn btn-success" href="{{ route('registration.class.index', $registration) }}" role="button">
                                Editar Plano de Aulas
                            </a>
                        </p>

                        @if(!$registration->classes()->count())

                            <p>Não existem aulas para essa matrícula. <a href="{{ route('registration.class.index', $registration) }}">Criar plano de aulas</a></p>

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
                                        <td data-search="{{ date('d/m/Y', strtotime($class->date)) }}">{{ date('d/m/Y', strtotime($class->date)) }}</td>
                                        <td data-search="{{ $class->time }}">{{ $class->time }}</td>
                                        <td>{{ $class->weekdayName }}</td>
                                        
                                        <td>
                                            <figure class="avatar mr-2 avatar-sm">
                                                <img src="{{ imageProfile($class->instructor->user->image) }}" alt="...">
                                            </figure>
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

<div class="modal fade show" id="modal-cancel-registration" tabindex="-1" role="dialog"aria-labelledby="exampleModalLabel" aria-modal="true">
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
                    <p>
                        Deseja cancelar essa matrícula?
                    </p>

                    <b>
                        Motivo do cancelamento
                    </b>
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

<div class="modal fade show" id="modal-class-week" tabindex="-1" role="dialog"aria-labelledby="exampleModalLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('registration.update', $registration) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alterar Plano de Aulas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- {{ Config::get('application.weekdays')[$week->weekday] }} às {{ Config::get('application.class_time')[$week->time] }} --}}

                    @foreach($registration->classWeek as $week)

                    <div class="row">

                        <div class="col form-group">
                            <x-form-input type="select" class="select2 class-props" name="class[{{ $week->weekday }}][weekday]" value="{{ $week->weekday }}"  :options="Config::get('application.weekdays')" />
                        </div>

                        <div class="col form-group">
                            <x-form-input type="select" class="select2 class-props" name="class[{{ $week->weekday }}][time]" value="{{ $week->time }}"  :options="Config::get('application.class_time')" />
                        </div>

                        <div class="col form-group">
                            <x-form-input type="select" class="select2 class-props" name="class[{{ $week->weekday }}][instructor_id]" value="{{ $week->instructor_id }}" :options="$instructors" />
                        </div>
                    </div>

                    @endforeach
                    
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times    "></i> Fechar</button>
                    <button type="submit" class="btn btn-primary"> <i class="fas fa-trash    "></i> Alterar Aulas</button>
                </div>
            </form>
        </div>
    </div>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times    "></i> Não</button>
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
<!-- Page Specific JS File -->
<script src="{{ asset('assets/js/page/datatables.js') }}"></script>
<script src="{{ asset('js/datatables.config.js') }}"></script>
<script>

    $(".datatables").dataTable({...config});
</script>

@endsection
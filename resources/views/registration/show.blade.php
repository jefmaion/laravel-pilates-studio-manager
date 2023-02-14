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
                    <img alt="image" src="{{ imageProfile($registration->student->user->image) }}"
                        class="rounded-circle author-box-picture">
                    <div class="clearfix"></div>
                </div>

                <div class="author-box-details">
                    <div class="author-box-name">
                        <a href="{{ route('student.show', $registration->student) }}">{{$registration->student->user->name }}</a>
                    </div>
                    <div class="author-box-description">
                        <div>
                            <strong><i class="fa fa-phone" aria-hidden="true"></i></strong>
                            {{ $registration->student->user->phone_wpp }} | {{ $registration->student->user->phone2 }}
                        </div>
                        <div>
                            <strong><i class="fa fa-phone" aria-hidden="true"></i></strong>
                            {{ $registration->student->user->email }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Plano Atual
                </h4>
                <div class="card-header-action">

                </div>
            </div>

            <div class="card-body">


                <div class="py-4">
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
                    <hr>

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
                    <hr>

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
                    <hr>

                    <p class="clearfix">
                        <div class="row text-dark">
                            <div class="col">
                                <span class="float-left ">
                                    Aulas
                                </span>
                            </div>
                            <div class="col">
                                <span class="float-right text-muted text-right">

                                    @if(empty($registration->classWeek))
                                    <a name="" id="" class="btn btn-primary" href="{{ route('registration.class.index', $registration) }}" >
                                        Adicionar/Alterar Aulas
                                    </a>
                                    @endif


                                    @foreach($registration->classWeek as $week)
                                    <div>{{ Config::get('application.weekdays')[$week->weekday] }} às {{ Config::get('application.class_time')[$week->time] }}</div>
                                    @endforeach
                                 </span>
                            </div>
                        </div>
                    </p>
                    <hr>

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
                    <hr>
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
                    
                    <hr>
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

        <a name="" id="" class="btn btn-secondary" href="{{ url()->previous() }}" role="button">
            <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
            Voltar
        </a>
    </div>

    <div class="col-12 col-lg-8 col-sm-12">



        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Informações
                </h4>
            </div>

            <div class="card-body">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Mensalidades ({{
                                count($registration->installments) }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Grade de Aulas ({{ count($registration->classes)
                            }})</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <table class="table tabsle-sm table-striped datatables w-100" id="table-def" style="font-size:12px">
                            <thead class="">
                                <tr>
                                    {{-- <th>Nº Mensalidade</th> --}}
                                    <th>Data</th>
                                    <th>Forma de Pagamento</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registration->installments as $inst)
                                <tr>
                                    {{-- <td scope="row">{{ $inst->order }}º</td> --}}
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
                        </table>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            
                        <p>
                            <a name="" id="" class="btn btn-primary" href="{{ route('registration.class.index', $registration) }}" role="button">
                                Adicionar/Alterar Aulas
                            </a>
                        </p>

                        <table class="table tabsle-sm table-striped datatables w-100" style="font-size:12px">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Dia</th>
                                    <th>Hora</th>
                                    <th>Instrutor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registration->classes as $class)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($class->date)) }}</td>
                                    <td>{{ $class->weekdayName }}</td>
                                    <td>{{ $class->time }}</td>
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
                        </table>

                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        Vestibulum imperdiet odio sed neque ultricies, ut dapibus mi maximus. Proin ligula massa,
                        gravida in lacinia efficitur, hendrerit eget mauris. Pellentesque fermentum, sem interdum
                        molestie finibus, nulla diam varius leo, nec varius lectus elit id dolor. Nam malesuada orci non
                        ornare vulputate. Ut ut sollicitudin magna. Vestibulum eget ligula ut ipsum venenatis ultrices.
                        Proin bibendum bibendum augue ut luctus.
                    </div>
                </div>

            </div>
        </div>



    </div>
</div>






@endsection


@section('outbody')

<div class="modal fade show" id="modal-cancel-registration" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('registration.destroy', $registration) }}" method="post">
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
                        <x-form-input type="textarea" name="cancellation_reason" />
                    <br>
                    <div class="alert alert-light" role="alert">
                        <strong>Atenção: </strong> As aulas não realizadas e as mensalidades am aberto serão excluídas!
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i
                            class="fas fa-times    "></i> Fechar</button>
                    <button type="submit" class="btn btn-danger"> <i class="fas fa-trash    "></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>
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
    <div class="modal-dialog modal-dialog-centered mosdal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Renovar Matrícula</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <h6>Plano</h6>
                <ul>
                    <li>{{ $registration->plan->name }}</li>
                    <li>
                        Valor atual: <b>R$ {{ USD_BRL($registration->final_value) }} </b> (R$ {{ USD_BRL($registration->value) }} - {{ $registration->discount }}%)
                   </li>
                   <li>Data de início: {{ $registration->end  }}</li>
                </ul>

           
                <h6> Aulas</h6>
                <ul>
                    @foreach($registration->classWeek as $week)
                    <li>
                        <b>{{ Config::get('application.weekdays')[$week->weekday] }}</b> às 
                        <b>{{ Config::get('application.class_time')[$week->time] }} </b> com 
                        <b>{{ $week->instructor->user->name }}</b>
                    </li>
                    @endforeach
                </ul>

                <h6>Parcelas</h6>
                <ul>
                    <li>
                         Primeira Parecela: <b>Débito/Dinheiro/Pix</b>
                    </li>
                    @if($registration->plan->duration > 1)
                    <li>
                        Segunda Parecela: <b>Cartão de Crédito</b>
                   </li>
                   @endif
                   
                </ul>
            </div>

            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times    "></i> Fechar</button>
                <button type="submit" class="btn btn-primary"> <i class="fas fa-trash    "></i> Alterar Informações</button>
                <a name="" id="" class="btn btn-primary" href="#" role="button"><i class="fas fa-trash    "></i> Renovar Matricula</a>
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
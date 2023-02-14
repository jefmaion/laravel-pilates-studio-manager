@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-4">
        <div class="card author-box">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Gerenciamento de Aulas
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
                        <a href="{{ route('student.show', $registration->student) }}">{{ $registration->student->user->name }}</a>
                    </div>
                    <div class="author-box-description">
                        <div>
                            
                            {{ $registration->plan->name }}
                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="p-4">
                @if($registration->classWeek->count() >= $registration->plan->class_per_week)
                    
                    <p class="text-warning text-center">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <b>O número de aulas por semana já está completo.</b>
                        {{-- O plano atual ({{ $registration->plan->name }}) permite {{ $registration->plan->class_per_week }} aula(s) por semana. --}}
                        
                    </p>

                @else
                <form action="{{ route('registration.class.store', $registration) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-7 form-group">
                            <label>Dia da Semana</label>
                            <x-form-input type="select" class="select2" name="weekday"
                                :options="appConfig('weekdays')" />
                        </div>
                        <div class="col-5 form-group">
                            <label>Horário</label>
                            <x-form-input type="select" class="select2" name="time"
                                :options="appConfig('class_time')" />
                        </div>
                        <div class="col-12 form-group">
                            <label>Dia da Semana</label>
                            <x-form-input type="select" class="select2" name="instructor_id" :options="$instructors" />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Adicionar Dia de Aula ({{ $registration->plan->class_per_week - $registration->classWeek->count() }})</button>
                </form>
                @endif
                <br>
                
                
            </div>
        </div>

        <a name="" id="" class="btn btn-secondary" href="{{ route('registration.show', $registration) }}" role="button">
            <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
            Voltar
        </a>
    </div>

    <div class="col-8">
        <div class="card">

            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Aulas/Professores
                </h4>
            </div>

            <div class="card-body">
                <table class="table table-striped datatables w-100">
                    <thead>
                        <tr>
                            <th>Dia</th>
                            <th>Hora</th>
                            <th>Instrutor</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registration->classWeek as $class)
                        <tr>
                            <td>
                                {{ appConfig('weekdays')[$class->weekday] }}
                            </td>
                            
                            <td>
                                {{ $class->time }}
                            </td>
                            
                            <td>
                                <figure class="avatar mr-2 avatar-sm">
                                    <img src="{{ imageProfile($class->instructor->user->image) }}" alt="...">
                                  </figure>
                                {{ $class->instructor->user->name }}
                            </td>

                            <td>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-{{ $class->id }}">
                                  Excluir
                                </button>
                                
                                @section('outbody')
                                    @parent
                                    <div class="modal fade show" id="modal-delete-{{ $class->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                        aria-modal="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <p>Deseja excluir esse dia de aula?</p>
                                                    <p class="text-warning">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        As aulas normais agendadas que ainda não foram realizadas serão excluídas!</p>
                                                </div>
                                                <div class="modal-footer bg-whitesmoke br">
                                                    <form action="{{ route('registration.class.destroy', [$registration, $class]) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"> <i class="fas fa-trash"></i>Excluir</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times"></i> Fechar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endsection
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="card">
    <div class="card-header">
        <h4>
            <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
            Grade de Aulas
        </h4>
    </div>
    <div class="card-body">
        <table class="table tables-sm table-striped datatables w-100">
            <thead>
                <tr>
                    <th>Nº Aula</th>
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
                    <td scope="row">{{ $class->class_order }}º</td>
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
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/page/datatables.js') }}"></script>
<script src="{{ asset('js/datatables.config.js') }}"></script>
<script>$(".datatables").dataTable({...config});</script>
@endsection
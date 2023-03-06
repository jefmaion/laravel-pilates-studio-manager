@extends('layouts.main')

@section('content')
<style>
    .table-single-hover td:hover {
    background-color: rgba(0,0,0,.075);
}
</style>
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
                    @include('registration.class-form')
                    <button type="submit" class="btn btn-primary btn-block">Adicionar Aula ({{ $registration->plan->class_per_week - $registration->classWeek->count() }})</button>
                </form>
                @endif
                <br>
                
                
            </div>
        </div>

        
    </div>

    <div class="col-8 d-flex">
        <div class="card flex-fill">

            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Aulas/Professores
                </h4>
            </div>

            <div class="card-body">




                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                            Aulas/Professores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                            Grade de Aulas
                        </a>
                    </li>
                </ul>

                <div class="tab-content tab-bosrdered" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <p>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modelId">
                                Agenda De Matrículas
                              </button>
                        </p>

                        <table class="table table-sm table-striped datatables w-100">
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
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{ $class->id }}">
                                          <i class="fas fa-trash    "></i>
                                        </button>
                                        
                                        @section('outbody')
                                            @parent
                                            <div class="modal fade show" id="modal-delete-{{ $class->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-modal="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-trash"></i> Excluir</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <p>Deseja excluir esse dia de aula?</p>
                                                            
                                                            
                                                        </div>
                                                        <div class="modal-footer bg-whitesmoke br">
                                                            <form action="{{ route('registration.class.destroy', [$registration, $class]) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times"></i> Fechar</button>
                                                                <button type="submit" class="btn btn-danger"> <i class="fas fa-trash"></i> Excluir</button>

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
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            
                        <x-data-table>
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
                        </x-data-table>

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


    <div class="col-12">
        
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Aulas/Professores
                </h4>

                <div class="card-header-action">
                    <a data-collapse="#mycard-collapse" class="btn btn-iscon btn-info" href="#"><i class="fas fa-minus"></i></a>
                  </div>
            </div>
            <div class="collapse show" id="mycard-collapse" style="">
                
            <div class="card-body">

                    
                
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->





<a name="" id="" class="btn btn-secondary" href="{{ route('registration.show', $registration) }}" role="button">
    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
    Voltar
</a>


@endsection

@section('outbody')
<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('registration.class.store', $registration) }}" method="post">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                
                <table class="table table-single-hover table-bordered table-sm w-100">
                    <thead>
                        <tr class="align-middle text-center ">
                            <th class=>Horário</th>
                            @foreach($calendar['weekdays'] as $item)
                            <th >{{ $item }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($calendar['classes'] as $time => $item)
                        

                        <tr class="">
                            <th class=" align-middle table-light text-center " >{{ $time }}</th>
                            <?php $i=0 ?>
                            @foreach($item as $k => $classes)
                            
                            <td class="text-center align-middle {{ ($i%2) ? 'tablse-light' : '' }}">
                                {!! $classes !!}
                            </td>
                            <?php $i++?>
                            @endforeach
                        </tr>
                        
                        @endforeach
                    </tbody>
                </table>

                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
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

<script>

    $('.day').click(function (e) { 
        e.preventDefault();

        time = $(this).data('time')
        weekday = $(this).data('weekday')

        $('[name="time"]').val(time).change();
        $('[name="weekday"]').val(weekday).change();
        $('#modelId').modal('show')
    });

</script>
@endsection
@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Agendar Reposição de Aula
                </h4>
            </div>
            <div class="card-body">

                <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                    <li class="media">
                        <figure class="avatar mr-2 avatar-xl mr-4">
                            <img src="{{ imageProfile($class->student->user->image) }}" alt="...">
                        </figure>
                        <div class="media-body">

                            <div class="media-title mb-3">
                                <a href="{{ route('student.show', $class->student) }}" class="h5">{{ $class->student->user->name }}</a> 
                                <div class=""></div>
                            </div>

                            <div class="tesxt-time">
                              
                                <div class="mb-2">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        {{ date('d/m/Y', strtotime($class->date)) }} |  <i class="fas fa-clock    "></i>
                                        {{ $class->time }}  | {{ Config::get('application.classTypes')[$class->type]['label']}}
                                </div>
                                <div class="mb-2">
                                    
                                </div>
                                <div class="mb-2">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    {{ $class->instructor->user->name }}
                                </div>
                                <p>
                                    <strong>Motivo da falta: </strong> {{ $class->comments }}
                                </p>
                            </div>
                            
                        </div>
                    </li>
            
                </ul>


                <form action="{{ route('calendar.replace.store', $class) }}" method="post">
                    @csrf
                    <div class="row">

           
                            {{-- <input  type="hidden" name="status" value="0">
                            <input  type="hidden" name="type" value="RP">
                            <input  type="hidden" name="classes_id" value="{{ $class->id }}">
                            <input  type="hidden" name="class_order" value="{{ $class->class_order }}"> --}}

                            <div class="col-6 form-group">
                                <label for="">Data</label>
                                <x-form-input type="date" name="date" value="{{ date('Y-m-d', strtotime($class->date)) }}" />
                            </div>

                            <div class="col-6 form-group">
                                <label for="">Horário</label>
                                <x-form-input type="select" class="select2" name="time" value=""  :options="Config::get('application.class_time')" />
                            </div>

                            <div class="col form-group">
                                <label for="">Professor</label>
                                <x-form-input type="select" class="select2" name="instructor_id" :options="$instructors" />
                            </div>
                
                    </div>

                   

                    <a name="" id="" class="btn btn-secondary" href="{{ route('calendar.index') }}" role="button">
                        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                        Voltar
                    </a>
                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelId">
                        Launch
                      </button> --}}
                    <button type="submit" class="btn btn-primary">Reagendar Aula</button>
                </form>
                
            </div>
        </div>
    </div>

    
</div>


<!-- Button trigger modal -->



<!-- Button trigger modal -->





@endsection

@section('outbody')
    {{-- @include('classes.modalcalendar') --}}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
@endsection

@section('scripts')

<script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script>
if (jQuery().select2) {
    $(".select2").select2();
}
</script>
@stop
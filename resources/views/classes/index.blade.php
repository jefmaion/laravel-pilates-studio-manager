@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>
            <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
            Agenda
        </h4>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col">
                @include('classes.calendar')
            </div>

            <div class="col-3">
                <div class="row">
                    <div class="col-12 form-group">
                        <label>Professor</label>
                        <x-form-input type="select" class="calendar-comp"   name="instructor_id" :options="$instructors" />
                    </div>

                    <div class="col-12 form-group">
                        <label>Tipo de Aula</label>
                        <x-form-input type="select" class="calendar-comp" name="type" :options="['AN' => 'Normal', 'RP' => 'Reposicao', 'AE' => 'Experimental']" />
                    </div>

                    <div class="col-12 form-group">
                        <label>Status da Aula</label>
                        <x-form-input type="select" class="calendar-comp" name="status" :options="[0 => 'Agendada', 1 => 'Realizada', 2 => 'Falta Justificada', 3 => 'Falta Sem Aviso']" />
                    </div>

                    <div class="col-12 form-group">
                        <label>Aluno</label>
                        <x-form-input type="select" class="calendar-comp" name="student_id" :options="$students" />
                    </div>
                </div>

                <div>Legenda: </div>
                @foreach(appConfig('classStatus') as $type)
                <span class="badge badge-pill badge-{{ $type['color'] }} m-1">{{ $type['label'] }}</span>
                @endforeach

                <hr>

                @foreach(appConfig('classTypes') as $key => $type)
                <div>
                <span class="badge badge-pill badge-dark p-1 m-1">{{ $key  }}</span>{{ $type['label'] }}
            </div>
                @endforeach
            </div>
        </div>
       
    </div>
</div>
@endsection


@section('outbody')
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                
            </div>
        </div>
    </div>
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
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

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">Calendário</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="false">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                    aria-controls="contact" aria-selected="false">Contact</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active show pt-3" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col">
                        @include('calendar.calendar')
                    </div>

                    <div class="col-3">

                        <div class="dropdown d-inline mr-2">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Ações
                            </button>
                            <div class="dropdown-menu" x-placement="bottom-start"
                                style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" href="#">Adicionar Aula</a>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12 form-group">
                                <label>Professor</label>
                                <x-form-input type="select" class="calendar-comp" name="instructor_id"
                                    :options="$instructors" />
                            </div>

                            <div class="col-12 form-group">
                                <label>Tipo de Aula</label>
                                <x-form-input type="select" class="calendar-comp" name="type"
                                    :options="['AN' => 'Normal', 'RP' => 'Reposicao', 'AE' => 'Experimental']" />
                            </div>

                            <div class="col-12 form-group">
                                <label>Status da Aula</label>
                                <x-form-input type="select" class="calendar-comp" name="status"
                                    :options="[0 => 'Agendada', 1 => 'Realizada', 2 => 'Falta Justificada', 3 => 'Falta Sem Aviso']" />
                            </div>

                            <div class="col-12 form-group">
                                <label>Aluno</label>
                                <x-form-input type="select" class="calendar-comp" name="student_id"
                                    :options="$students" />
                            </div>
                        </div>

                        <div>Legenda: </div>
                        @foreach(appConfig('classStatus') as $type)
                        <span class="badge badge-pill badge-{{ $type['color'] }} m-1">{{ $type['label'] }}</span>
                        @endforeach

                        <hr>


                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                Sed sed metus vel lacus hendrerit tempus. Sed efficitur velit tortor, ac efficitur est lobortis
                quis. Nullam lacinia metus erat, sed fermentum justo rutrum ultrices. Proin quis iaculis tellus.
                Etiam ac vehicula eros, pharetra consectetur dui. Aliquam convallis neque eget tellus efficitur,
                eget maximus massa imperdiet. Morbi a mattis velit. Donec hendrerit venenatis justo, eget
                scelerisque tellus pharetra a.
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
<link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('scripts')

<script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/page/datatables.js') }}"></script>
<script src="{{ asset('js/datatables.config.js') }}"></script>
@stop
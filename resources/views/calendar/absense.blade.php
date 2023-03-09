@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Registrar Falta 
                </h4>
            </div>
            <div class="card-body">

                <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                    <li class="media">
                        <figure class="avatar mr-2 avatar-xl mr-4">
                            <img src="{{ imageProfile($class->student->user->image) }}" alt="...">
                        </figure>
                        <div class="media-body">

                            <div class="media-right">
                                <div class="text-primary">Approved</div>
                            </div>

                            <div class="media-title mb-3">
                                <a href="{{ route('student.show', $class->student) }}" class="h5">{{
                                    $class->student->user->name }}</a>
                                <div class=""></div>
                            </div>

                            <div class="tesxt-time">

                                <div class="mb-2">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    {{ date('d/m/Y', strtotime($class->date)) }} | <i class="fas fa-clock    "></i>
                                    {{ $class->time }} | {{
                                    Config::get('application.classTypes')[$class->type]['label']}}
                                </div>
                                <div class="mb-2">

                                </div>
                                <div class="mb-2">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    {{ $class->instructor->user->name }}
                                </div>
                            </div>

                        </div>
                    </li>
                </ul>


                <form action="{{ route('calendar.update', $class) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="row">


                        <div class="col-12 form-group">
                            <label for="">Tipo de Falta </label>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadioInline1" name="status" class="custom-control-input" value="3" checked>
                                <label class="custom-control-label" for="customRadioInline1">Falta</label>
                            </div>

                            @if($class->type !== 'RP')

                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadioInline2" name="status" class="custom-control-input"
                                    value="2">
                                <label class="custom-control-label" for="customRadioInline2">Falta Justificada</label>
                            </div>
                            @endif
                        </div>

                        <div class="col-12 form-group notice">
                            <label for="">Motivo da Falta</label>
                            <x-form-input type="textarea" rows="5" name="comments" />
                        </div>

                    </div>


                    <div class="form-group" id="replace-container">
                        <x-form-input type="switch" name="replace" label="Agendar Reposicao" value="0" />
                    </div>


                    <a name="" id="" class="btn btn-secondary" href="{{ route('calendar.index') }}" role="button">
                        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                        Voltar
                    </a>
                    <button type="submit" class="btn btn-primary">Registrar Falta</button>
                </form>

            </div>
        </div>
    </div>


</div>


<!-- Button trigger modal -->





@endsection

@section('outbody')


@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script>
    // Select2
if (jQuery().select2) {
    $(".select2").select2();
}


replaceToggle($('[name="status"]:checked').val())

$('[name="status"]').click(function(e) {
    replaceToggle($(this).val());
});

function replaceToggle(value) {

    $('#replace-container').hide();
    $('[name="replace"]').prop('disabled', true);

    if(value == 2) {
        $('[name="replace"]').prop('disabled', false);
        $('#replace-container').fadeIn();
        return 
    }
}


</script>
@endsection
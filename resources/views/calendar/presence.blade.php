@extends('layouts.main')

@section('breadcrumb')
<nav aria-label="breadcrumb mr-0">
    <ol class="breadcrumb mt-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Registrar Presença</li>
    </ol>
</nav>
@endsection

@section('content')
<form action="{{ route('calendar.presence.store', $class) }}" method="post">
    @csrf
    <input type="hidden" name="status" value="1">

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-6">
                    <h6>Aluno</h6>
                    <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">

                        <li class="media">



                            <figure class="avatar mr-2 avatar-xl mr-4">
                                <img src="{{ imageProfile($class->student->user->image) }}" alt="...">
                            </figure>

                            <div class="media-body">

                                <div class="media-title mb-3">
                                    <a href="{{ route('student.show', $class->student) }}" class="h6">{{
                                        $class->student->user->name }}</a>
                                    <div class=""></div>
                                </div>

                                <div class="tesxt-time">

                                    <div class="mb-2">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        {{ date('d/m/Y', strtotime($class->date)) }} |
                                        <i class="fas fa-clock"></i>{{ $class->time }} |
                                        {{ Config::get('application.classTypes')[$class->type]['label']}}
                                    </div>

                                    <div class="mb-2">
                                        <a href="{{ route('instructor.show', $class->instructor) }}" clawss="h6">{{
                                            $class->instructor->user->name }}</a>
                                    </div>

                                </div>

                            </div>
                        </li>

                    </ul>

                </div>
                <div class="col-6">
                    <h6>Professor</h6>
                    <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">

                        <li class="media">

                            <figure class="avatar mr-2 avatar-xl mr-4">
                                <img src="{{ imageProfile($class->student->user->image) }}" alt="...">
                            </figure>

                            <div class="media-body">

                                <div class="media-title mb-3">
                                    <a href="{{ route('student.show', $class->student) }}" class="h6">{{
                                        $class->student->user->name }}</a>
                                    <div class=""></div>
                                </div>

                                <div class="tesxt-time">

                                    <div class="mb-2">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        {{ date('d/m/Y', strtotime($class->date)) }} |
                                        <i class="fas fa-clock"></i>{{ $class->time }} |
                                        {{ Config::get('application.classTypes')[$class->type]['label']}}
                                    </div>

                                    <div class="mb-2">
                                        <a href="{{ route('instructor.show', $class->instructor) }}" clawss="h6">{{
                                            $class->instructor->user->name }}</a>
                                    </div>

                                </div>

                            </div>
                        </li>

                    </ul>

                </div>

                <div class="col-12">
                    <hr>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label>Exercícios/Aparelhos Utilizados</label>
                            <x-form-input type="select" class="select2" multiple="multiple" name="exercices[]"
                                :options="$exercices" />
                        </div>

                        <div class="col-12 form-group">
                            <label>Evolução</label>
                            <x-form-input type="textarea" class="summernote" rows="5" name="evolution" />

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <a name="" id="" class="btn btn-secondary" href="{{ route('calendar.index') }}" role="button">
        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
        Voltar
    </a>

    <button type="submit" class="btn btn-success">
        <i class="fas fa-check-circle    "></i>
        Marcar Presença
    </button>

</form>

@endsection





@section('css')
<link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/bundles/summernote/summernote-bs4.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/bundles/summernote/summernote-bs4.js') }}"></script>
<script>
    $('#btn-add-exercice').click(function (e) { 
        
        var form = $('#form-add-exercice');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '{{ route('calendar.exercice.add') }}',
            data: $(form).serialize(),
            success: function (response) {
                $('#table-exercices').append(response)
                $('#modelId').modal('hide')
            }
        });

        
    });

    if (jQuery().summernote) {
        $(".summernote").summernote({
            dialogsInBody: true,
            minHeight: 250,
            toolbar: [
                // ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                // ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                // ['table', ['table']],
                ['insert', ['picture']],
                // ['view', ['fullscreen', 'codeview', 'help']],
            ],
        });

        $('.summernote.is-invalid').next().addClass('border border-danger')
    }

    


</script>
@endsection
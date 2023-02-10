@extends('layouts.main')

@section('content')


<div class="card">
    <div class="card-header">
        <h4>
            <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
            Evolução de Aula
        </h4>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-5">
                <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">

                    <li class="media">

                        <figure class="avatar mr-2 avatar-xl mr-4">
                            <img src="{{ imageProfile($class->student->user->image) }}" alt="...">
                        </figure>

                        <div class="media-body">

                            <div class="media-title mb-3">
                                <a href="{{ route('student.show', $class->student) }}" class="h5">{{
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
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    {{ $class->instructor->user->name }}
                                </div>
                            </div>

                        </div>
                    </li>

                </ul>
            </div>
            <div class="col-7">
                <p><b>Comentários da Aula</b></p>
                {{ $class->comments }}
            </div>
            <div class="col-12">
                <hr>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-lg mb-3" data-toggle="modal" data-target="#modelId">
                    Adicionar Exercício/Aparelho
                </button>

                <div class="row">

                    <div class="col">
                        <table class="table tabsle-sm table-striped datatables w-100" id="table-def">
                            <thead>
                                <tr>
                                    <th>Exercício/Equipamento</th>
                                    <th>COmentários</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($class->evolution->exercices))
                                @foreach($class->evolution->exercices as $exer)
                                <tr>
                                    <td scope="row">
                                        <h6>{{ $exer->exercice->name }}</h6>
                                    </td>
                                    <td>{!! $exer->comments !!}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>




@endsection

@section('outbody')

<!-- Modal -->
<div class="modal" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('evolution.store', $class) }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row">

                        <div class="form-group col-12">
                            <label for="">Exercícios/Aparelhos Utilizados</label>
                            <x-form-input type="select" class="select2" name="exercice_id" value="" :options="$exercices" />
                        </div>

                        <div class="form-group col-12">
                            <textarea class="form-control summernote-simple2" name="comments"></textarea>
                        </div>
                    </div>
                    
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
<link rel="stylesheet" href="{{ asset('assets/bundles/summernote/summernote-bs4.css') }}">
@endsection

@section('scripts')

<script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/bundles/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/page/datatables.js') }}"></script>
<script src="{{ asset('js/datatables.config.js') }}"></script>
<script>
if (jQuery().select2) {
    $(".select2").select2();
}
</script>
<script>
    $(".datatables").dataTable({...config, ressponsive:false, pageLength: 10});
</script>
<script>
    if (jQuery().select2) {
        $(".select2").select2();
    }
    if (jQuery().summernote) {
        $(".summernote").summernote({
          dialogsInBody: true,
          minHeight: 250
        });
        $(".summernote-simple2").summernote({
          dialogsInBody: true,
          minHeight: 150,
          toolbar: [
            ["style", ["bold", "italic", "underline", "clear"]],
            ["font", ["strikethrough"]],
            ["para", ["paragraph"]]
          ]
        });
      }
    </script>
@stop

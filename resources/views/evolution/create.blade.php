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

        </div>

    


    </div>
</div>

<div class="row">
    <div class="col-12">

        <div class="row">

            <div class="col">
                <div class="card">

                    <div class="card-header">
                        <h4>
                            <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                            Ações da Aula
                        </h4>
                    </div>

                    <div class="card-body">
                        @if(empty($exercice->id))
                        <form action="{{ route('evolution.store', $class) }}" method="post">
                        @else
                        <form action="{{ route('evolution.update', [$class, $exercice]) }}" method="post">
                        @method('PUT')
                        @endif
                        @csrf
                        <div class="row">

                            <div class="form-group col-12">
                                <label for="">Exercícios/Aparelhos Utilizados</label>
                                <x-form-input type="select" class="select2" name="exercice_id" value="{{ $exercice->exercice_id }}" :options="$exercices" />
                            </div>

                            <div class="form-group col-12">
                                <label for="">Comentários da execução</label>
                                <textarea class="form-control"  rows="4" name="comments">{{ $exercice->comments }}</textarea>
                            </div>

                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-block btn-lg">Adicionar Ação</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                
            </div>

            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                            Ações Realizadas
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="datatables w-100 table-striped" id="table-def">
                            <thead class="d-none">
                                <tr>
                                    <th>Exercício/Equipamento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($class->evolution->exercices))
                                @foreach($class->evolution->exercices as $exer)
                                <tr>
                                    <td class="p-3">
                                        <h6>{{ $exer->exercice->name }}</h6>
                                        <ul>
                                            <li>
                                                {!! $exer->comments !!}
                                                <div> <a href="{{ route('evolution.edit',  [$class, $exer]) }}">Editar</a> | 
                                                
                                                 <a href="#" data-toggle="modal" data-target="#modal-delete-{{ $exer->id }}">Excluir</a>
                                                </div>
                                            </li>
                                        </ul>

                                        @section('outbody')
                                        @parent
                                        <!-- Modal -->
                                        <div class="modal fade show" id="modal-delete-{{ $exer->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                            aria-modal="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Deseja excluir esse registro? {{ $exer->id }}
                                                    </div>
                                                    <div class="modal-footer bg-whitesmoke br">
                                                        <form action="{{ route('evolution.destroy', [$class, $exer]) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"> <i class="fas fa-trash    "></i> Excluir</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times    "></i> Fechar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endsection
                                        
                                    </td>
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

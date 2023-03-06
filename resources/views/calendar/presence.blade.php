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
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                   Aluno
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
                                    {{ date('d/m/Y', strtotime($class->date)) }} |  
                                    <i class="fas fa-clock"></i>{{ $class->time }}  | 
                                    {{ Config::get('application.classTypes')[$class->type]['label']}}
                                </div>

                            </div>
                            
                        </div>
                    </li>
            
                </ul>

                
                @csrf
                <input type="hidden" name="status" value="1">

                <div class="row">
                    {{-- <div class="form-group col">
                        <label for="">Professor</label>
                        <x-select2-image name="instructor_id" value="{{ $class->instructor_id }}" :options="$instructors" />
                    </div>

                    <div class="col-12 form-group notice">
                        <label for="">Comentários da aula</label>
                        <x-form-input type="textarea" rows="5" name="comments" />
                    </div> --}}

                </div>

               
                
                
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Professor
                </h4>
            </div>
            
            <div class="card-body">

                <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">

                    <li class="media">

                        <figure class="avatar mr-2 avatar-xl mr-4">
                            <img src="{{ imageProfile($class->instructor->user->image) }}" alt="...">
                        </figure>

                        <div class="media-body">

                            <div class="media-title mb-3">
                                <a href="{{ route('instructor.show', $class->instructor) }}" class="h5">{{ $class->instructor->user->name }}</a> 
                                <div class=""></div>
                            </div>

                            <div class="tesxt-time">
                              
                             


                            </div>
                            
                        </div>
                    </li>
            
                </ul>

                
                @csrf
                <input type="hidden" name="status" value="1">

                <div class="row">
                    {{-- <div class="form-group col">
                        <label for="">Professor</label>
                        <x-select2-image name="instructor_id" value="{{ $class->instructor_id }}" :options="$instructors" />
                    </div>

                    <div class="col-12 form-group notice">
                        <label for="">Comentários da aula</label>
                        <x-form-input type="textarea" rows="5" name="comments" />
                    </div> --}}

                </div>

               
                
                
            </div>
        </div>
    </div>

    <div class="col">
        
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Evolução da aula
                </h4>
            </div>
            <div class="card-body">
                <p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelId">
                        Adicionar Exercício
                      </button>
                </p>
                
               <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Exercício</th>
                        <th>Comentários</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classExercices as $exer)
                    <tr>
                        <th scope="row">{{ $exer->exercice->name }}</th>
                        <td>{{ $exer->comments }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
               </table>
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


@section('outbody')
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <form action="{{ route('calendar.exercice.add') }}" method="POST">
        @csrf
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Exercícios</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="classes_id" value="{{ $class->id }}">

                    <div class="row">
                        <div class="form-group col">
                            <label for="">Exercício/Aparelho</label>
                            <x-form-input type="select" class="select2" name="exercice_id"  :options="$exercices" />
                        </div>

                        <div class="col-12 form-group notice">
                            <label for="">Comentários do Exercício</label>
                            <x-form-input type="textarea" rows="10" name="comments" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script>


    

    $('#submit-form-exercice').click(function (e) { 
        
        var form = $('#form-add-exercice');

        $.ajax({
            type: 'POST',
            url: '{{ route('calendar.exercice.add') }}',
            data: $(form).serialize(),
            success: function (response) {
                alert('asdasd')
                console.log(response)
            }
        });

        
    });

    


</script>
@endsection
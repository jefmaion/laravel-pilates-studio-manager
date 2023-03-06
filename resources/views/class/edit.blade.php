@extends('layouts.main')

@section('breadcrumb')
<nav aria-label="breadcrumb mr-0">
    <ol class="breadcrumb mt-0">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href=" {{ route('class.index') }}">Aulas</a></li>
      <li class="breadcrumb-item"><a href=" {{ route('class.show', $class) }}">Aula</a></li>
      <li class="breadcrumb-item active" aria-current="page">Editar Aula</li>
    </ol>
  </nav>
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Aulas
                </h4>

                <div class="card-header-action">
                    {{-- <a name="" id="" class="btn btn-success btn-lg" href="{{  route('class.create')  }}" role="button">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Cadastrar Novo Plano
                    </a> --}}
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <h5>{{ dateExt($class->date) }} - {{ $class->time }}h </h5>

                        <p>
                            {!! $class->statusClass !!}
                            <span class="badge badge-pill badge-light"> {{ $class->type }} </span>
                        </p>

                        <p>{{ $class->student->user->name }}</p>
                        <p>{{ $class->instructor->user->name }}</p>

                        <hr>


                        <div class="row">
                            <div class="col-4">


                                <div class="row">
                                    <div class="form-group col">
                                        <label for="">Professor</label>
                                        <x-form-input type="select" name="instructor_id" :options="$exercices" />
                                    </div>
                
                                    <div class="col-12 form-group notice">
                                        <label for="">Comentários da aula</label>
                                        <x-form-input type="textarea" rows="5" name="comments" />
                                    </div>
                                </div>

                            </div>
                            <div class="col">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Exercício</th>
                                            <th>Comentários</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td scope="row">Barrel</td>
                                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero perspiciatis mollitia itaque soluta similique consequuntur corporis hic. Voluptatibus porro asperiores aperiam, consectetur quo veniam animi rerum recusandae eum ipsa suscipit!</td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>


                        <a name="" id="" class="btn btn-secondary" href="{{ route('class.index') }}" role="button">
                            <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                            Voltar
                        </a>
            
                        <div class="dropdown d-inline">
            
                            
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Ações
                            </button>
            
                            <div class="dropdown-menu" x-placement="bottom-start">
            
            
                                <div class="dropdown-divider"></div>
            
                                <a class="dropdown-item has-icon" href="{{ route('class.edit', $class) }}">
                                    <i class="fas fa-edit    "></i> Editar Aula
                                </a>
            
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Exercícios Executados
                </h4>
            </div>
            <div class="card-body">
                
            </div>
        </div>
    </div>
    
</div>
@endsection


@section('css')
    @include('layouts.plugins.datatables', ['file' => 'css'])
@endsection

@section('scripts')
    @include('layouts.plugins.datatables', ['file' => 'js'])
    <script src="{{ asset('js/datatables.config.js') }}"></script>
    <script>
        $("#table-def").dataTable({...config,
            ajax:'/class',
            columns: [
                {data: 'date'},
                {data: 'time'},
                {data: 'student'},
                {data: 'instructor'},
            ]
        });
    </script>

@endsection
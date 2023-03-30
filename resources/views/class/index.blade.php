@extends('layouts.main')

@section('breadcrumb')
<nav aria-label="breadcrumb mr-0 bg-none">
    <ol class="breadcrumb mt-0">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Aulas</li>
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
                <table class="table table-striped w-100" id="table-def">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Aluno</th>
                            <th>Professor</th>
                        </tr>
                    </thead>
                </table>
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
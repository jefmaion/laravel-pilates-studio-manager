@extends('layouts.main')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mt-0">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Cadastro de Alunos</li>
    </ol>
  </nav>
@endsection


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Cadastro de Alunos
                </h4>

                <div class="card-header-action">
                    <a name="" id="" class="btn btn-success" href="{{  route('student.create')  }}" role="button">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Cadastrar Novo Aluno
                    </a>
                </div>
            </div>

            

            <div class="card-body">
                <x-data-table>
                    <thead>
                        <tr>
                            <th width="1%">Foto</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Telefone 2</th>
                            <th>Data de Cadastro</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </x-data-table>
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
        $(".datatables").dataTable({...config,
            ajax:'/student',
            columns: [
                {data: 'image'},
                {data: 'name'},
                {data: 'phone_wpp'},
                {data: 'phone2'},
                {data: 'created_at'},
                {data: 'status'},
            ]
        });
    </script>
@endsection
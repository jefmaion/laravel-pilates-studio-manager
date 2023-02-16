@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Cadastro de Professores
                </h4>

                <div class="card-header-action">
                    <a name="" id="" class="btn btn-success" href="{{  route('instructor.create')  }}" role="button">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Cadastrar Novo Professor
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped w-100" id="table-def" style="font-size:14px">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>Formação</th>
                            <th>Telefone</th>
                            <th>Telefone 2</th>
                            <th>Data de Cadastro</th>
                            <th>Status</th>
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
            ajax:'/instructor/list',
            columns: [
                {data: 'image'},
                {data: 'name'},
                {data: 'profession'},
                {data: 'phone_wpp'},
                {data: 'phone2'},
                {data: 'created_at'},
                {data: 'status'},
            ]
        });
    </script>
@endsection
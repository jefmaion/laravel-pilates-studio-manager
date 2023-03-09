@extends('layouts.main')

@section('breadcrumb')
<nav aria-label="breadcrumb mr-0">
    <ol class="breadcrumb mt-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Matrículas</li>
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
                    Matrículas
                </h4>

                <div class="card-header-action">
                    <a name="" id="" class="btn btn-success" href="{{  route('registration.create')  }}" role="button">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Nova Matrícula
                    </a>
                </div>
            </div>
            <div class="card-body">
                <x-data-table id="table-def">
                    <thead>
                        <tr>
                            <th width="1%">Aluno</th>
                            <th>Aluno</th>
                            <th>Plano</th>
                            <th>Vencimento</th>
                            <th>Renovação</th>
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
        $("#table-def").dataTable({...config,
            ajax:'/registration',
            columns: [
                {data: 'image'},
                {data: 'student'},
                {data: 'plan'},
                {data: 'end'},
                {data: 'renew'},
                {data: 'status'},
            ]
        });
    </script>
@endsection
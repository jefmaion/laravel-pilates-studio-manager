@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Evoluções
                </h4>

                <div class="card-header-action">
                    <a name="" id="" class="btn btn-success btn-lg" href="{{  route('evolution.create')  }}" role="button">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Cadastrar Nova Evolução
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped w-100" id="table-def">
                    <thead>
                        <tr>
                            <th>Aula</th>
                            <th>Aluno</th>
                            <th>Instrutor</th>
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
            ajax:'/evolution',
            columns: [
                {data: 'date'},
                {data: 'student'},
                {data: 'instructor'},
            ]
        });
    </script>

@endsection
@extends('layouts.main')

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



                
                <table class="table table-sm table-striped w-100" id="table-def" style="font-size:14px">
                    <thead>
                        <tr>
                            <th>Aluno</th>
                            <th>Aluno</th>
                            <th>Telefones</th>
                            <th>Valor</th>
                            <th>Vencimento</th>
                            <th>Renovação</th>
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
            ajax:'/registration',
            columns: [
                {data: 'image'},
                {data: 'student'},
                {data: 'phone'},
                {data: 'value'},
                {data: 'end'},
                {data: 'renew'},
                {data: 'status'},
            ]
        });

    </script>
@endsection
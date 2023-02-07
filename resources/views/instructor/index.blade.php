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
<link rel="stylesheet" href="assets/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
@endsection

@section('scripts')
<script src="assets/bundles/datatables/datatables.min.js"></script>
<script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/bundles/jquery-ui/jquery-ui.min.js"></script>
<!-- Page Specific JS File -->
<script src="assets/js/page/datatables.js"></script>
<script src="{{ asset('js/datatables.config.js') }}"></script>
<script>

    $("#table-def").dataTable({...config,
        ajax:'/instructor/list',
        columns: [
            {data: 'name'},
            {data: 'profession'},
            {data: 'phone_wpp'},
            {data: 'phone2'},
            {data: 'created_at'},
            {data: 'status'},
        ]
    });
</script>
<script>
    $(document).ready(function () {
     
    });
</script>
@endsection
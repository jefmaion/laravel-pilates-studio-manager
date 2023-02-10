@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Contas a Receber
                </h4>

                <div class="card-header-action">
                    <a name="" id="" class="btn btn-success btn-lg" href="{{  route('payable.create')  }}" role="button">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Adicionar
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped w-100" id="table-def">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            
                           
                            <th>Valor</th>
                            <th>Forma de Pagamento</th>
                            <th>Vencimento</th>
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
<link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('assets/js/page/datatables.js') }}"></script>
<script src="{{ asset('js/datatables.config.js') }}"></script>
<script>


    $("#table-def").dataTable({...config,
        ajax:'/account/payable',
        columns: [
            {data: 'description'},
            {data: 'value'},
            {data: 'payment_method'},
            {data: 'due_date'},
            {data: 'status'},
        ]
    });






</script>
<script>
    $(document).ready(function () {
     
    });
</script>
@endsection
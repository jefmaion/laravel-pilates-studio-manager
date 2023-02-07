@extends('layouts.main')

@section('content')

<h4 class="mb-4">Gerenciar Matrículas</h4>

<div class="row mt-sm-4">
    
    <div class="col-12 col-md-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>Matrícula</h4>
            </div>
            <div class="card-body">

                @if(!isset($student->registration))

                <form action="{{ route('registration.store', $student) }}" method="post">
                    @csrf

                    <div class="row">

                        <div class="col-12 form-group">
                            <label>Inicio das Aulas</label>
                            <x-form-input type="date" name="start_registration" value="{{ date('Y-m-d') }}" />
                        </div>

                        <div class="col-8 form-group">
                            <label>Plano</label>
                            <x-form-input type="select" name="plan_id" :options="$plans"   />
                        </div>

                        <div class="col-4 form-group">
                            <label>Dia de Vencimento</label>
                            <x-form-input type="number" name="due_date" />
                        </div>

                        <div class="col-4 form-group">
                            <label>Valor</label>
                            <x-form-input type="text" classs="money" name="value" />
                        </div>

                        <div class="col-4 form-group">
                            <label>Desconto</label>
                            <x-form-input type="number" name="discount" />
                        </div>

                        <div class="col-4 form-group">
                            <label>Valor Final</label>
                            <x-form-input type="text" classs="money" name="final_value" />
                        </div>

                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle"></i>
                        Salvar
                    </button>

                </form>

                @else

                <a class="dropdown-item has-icon" href="#" data-toggle="modal"
                            data-target="#modal-cancel-registration">
                            <i class="fas fa-trash    "></i> Cancelar Matrícula
                        </a>

                <table class="table tabsle-sm table-striped" id="table-def">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->registration->installments as $inst)
                        <tr>
                            <td scope="row">{{ date('d/m/Y', strtotime($inst->due_date)) }}</td>
                            <td scope="row">{{ $inst->description }}</td>
                            <td>R$ {{ USD_BRL($inst->value) }}</td>
                            <td>
                                {!! $inst->status_label !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif




            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-social/bootstrap-social.css') }}">
@endsection

@section('outbody')
<!-- Modal -->
<div class="modal fade show" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja excluir esse registro?
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form action="{{ route('student.destroy', $student) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"> <i class="fas fa-trash    "></i> Excluir</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i
                            class="fas fa-times    "></i> Fechar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@if($student->registration)
<div class="modal fade show" id="modal-cancel-registration" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja cancelar essa matrícula?
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form action="{{ route('registration.destroy', [$student, $student->registration]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"> <i class="fas fa-trash    "></i> Cancelar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i
                            class="fas fa-times    "></i> Fechar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script src="{{ asset('assets/js/page/datatables.js') }}"></script>
<script src="{{ asset('js/datatables.config.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.config.js') }}"></script>
    <script>

        $("#table-def").DataTable(config);

    </script>
    <script>

        let plan
        let discount

        $('[name=plan_id]').change(function (e) { 
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "/plan/" + $(this).val(),
                dataType: "json",
                success: function (response) {
                    plan = response
                    $('[name=value]').val(plan.value)
                    $('[name=discount]').val(0)
                    $('[name=final_value]').val(plan.value)
                }
            });
        });

        $('[name=discount]').keyup(function (e) { 
            e.preventDefault();
            value = $(this).val();
            discount = value
            calculateDiscount()
            
        });

        function calculateDiscount() {

            total = plan.value

            if(discount || discount != 0)  {
                total = plan.value - (plan.value * (discount/100))
            }


            $('[name=final_value]').val(total)
        }
    </script>
@endsection
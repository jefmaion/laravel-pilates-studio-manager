@extends('layouts.main')

@section('breadcrumb')
<nav aria-label="breadcrumb mr-0">
    <ol class="breadcrumb mt-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('registration.index') }}">Matrículas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Nova Matrícula</li>
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
                    Nova Matrícula
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('registration.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            @include('registration.form')
                        </div>

                    </div>

                    <hr>

                    <a name="" id="" class="btn btn-secondary" href="{{ route('registration.index') }}" role="button">
                        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                        Voltar
                    </a>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle"></i>
                        Salvar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Button trigger modal -->
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.config.js') }}"></script>
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

                $('.money').change();
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
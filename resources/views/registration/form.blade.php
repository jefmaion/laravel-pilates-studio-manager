<div class="row">

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">

                <div class="row">

                    <div class="col-4 form-group">
                        <label>Inicio das Aulas</label>
                        <x-form-input type="date" name="start_registration" value="{{ date('Y-m-d') }}" />
                    </div>

                    {{-- <div class="col-8 form-group">
                        <label>Plano</label>
                        <x-form-input type="select" name="plan_id" :options="$plans"   />
                    </div> --}}

                    <div class="col-3 form-group">
                        <label>Dia de Vencimento</label>
                        <x-form-input type="number" name="due_date" />
                    </div>

                    <div class="col-3 form-group">
                        <label>Valor</label>
                        <x-form-input type="text" classs="money" name="value" />
                    </div>

                    <div class="col-3 form-group">
                        <label>Desconto</label>
                        <x-form-input type="number" name="discount" />
                    </div>

                    <div class="col-3 form-group">
                        <label>Valor Final</label>
                        <x-form-input type="text" classs="money" name="final_value" />
                    </div>

                </div>


                
                <a name="" id="" class="btn btn-secondary" href="{{ route('plan.index') }}" role="button">
                    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                    Voltar
                </a>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle"></i>
                    Salvar
                </button>

            </div>

        </div>

    </div>
   
    

</div>



@section('scripts')
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
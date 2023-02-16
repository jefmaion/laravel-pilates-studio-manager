@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Renovar Matrícula
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('registration.store') }}" method="post">
                    @csrf
                    <div class="row">

                        <div class="col-12">

                                {{-- <div class="row">

                                    <div class="col-12 form-group">
                                        <label>Aluno</label>
                                        <x-form-input type="select" class="select2" value="{{ $registration->student->id }}" name="student_id" :options="$students" />
                                    </div>
            
                                    <div class="col-2 form-group">
                                        <label>Inicio das Aulas</label>
                                        <x-form-input type="date" name="start" value="{{ date('Y-m-d') }}" />
                                    </div>
            
                                    <div class="col-2 form-group">
                                        <label>Dia de Vencimento</label>
                                        <x-form-input type="number" name="due_date" value="{{ $registration->due_date }}" />
                                    </div>
            
                                    <div class="col-3 form-group">
                                        <label>Plano</label>
                                        <x-form-input type="select" class="select2" name="plan_id" value="{{ $registration->plan->id }}" :options="$plans" />
                                    </div>
            
                                    <div class="col-2 form-group">
                                        <label>Valor</label>
                                        <x-form-input type="text" classs="money" name="value" value="{{ $registration->value }}" />
                                    </div>
            
                                    <div class="col-1 form-group">
                                        <label>Desconto</label>
                                        <x-form-input type="number" name="discount" value="{{ $registration->discount }}" />
                                    </div>
            
                                    <div class="col-2 form-group">
                                        <label>Valor Final</label>
                                        <x-form-input type="text" classs="money" name="final_value" value="{{ $registration->final_value }}" />
                                    </div>

                                </div> --}}
                                @include('registration.form')

                        </div>

                        <div class="col-12">
                            <hr>
                            

                            <div class="row">
                                <div class="col">
                                    <p><strong>Dias de Aulas</strong></p>
                                </div>
                            
                            </div>



                         
                            <table class="table table-striped table-bordered" >
                                <thead class="thead-dark">
                                    <tr>
                                       @foreach(Config::get('application.weekdays') as $i => $week)
                                        <th>
                                            {{ $week }}
                                        </th>
                                       @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach(Config::get('application.weekdays') as $i => $week)
                                            <td>

                                                <input type="hidden" name="class[{{ $i }}][weekday]" value="{{ $i }}">

                                                <x-form-input type="select" class="select2 class-props" value="{{ ($registration->getDataByWeekday($i)) ? $registration->getDataByWeekday($i)->time : null }}" name="class[{{ $i }}][time]" :options="Config::get('application.class_time')" />
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        @foreach(Config::get('application.weekdays') as $i => $week)
                                            <td> 
                                                <x-form-input type="select" class="select2 class-props" value="{{ ($registration->getDataByWeekday($i)) ? $registration->getDataByWeekday($i)->instructor_id : null }}" name="class[{{ $i }}][instructor_id]" :options="$instructors" />
                                            </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
        
                           
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

@section('outbody')
<!-- Modal -->

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script>
    let plan
    let discount

    // Select2
  if (jQuery().select2) {
    $(".select2").select2();
  }

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


    $(document).ready(function () {
        
        $('#form').on('submit', function(e) {
            e.preventDefault();

            form = this;

            $.ajax({
                type: $(form).attr('method'),
                url: $(form).attr('action'),
                data: new FormData(form),
                contentType:false,
                cache:false,
                processData:false,
                beforeSend: function() {
                
                },
                success: function(e) {
                    $('#table-class').append(e)
                    $('.class-props').val("")
                    $('#modelId').modal('hide')
                    $('.remove-tr-class').click(function(e) {
                        $(this).closest('tr').remove();
                    });
                }
            });

        });


    });

</script>
@endsection
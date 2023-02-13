@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header card-primary">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Adicionar Aulas
                </h4>
            </div>
            <div class="card-body">


                @if($registration->classWeek->count() >= $registration->plan->class_per_week)
                    nao pode
                @else

                <form action="{{ route('registration.classes.store', $registration) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-7 form-group">
                            <label>Dia da Semana</label>
                            <x-form-input type="select" class="sselect2" name="weekday"
                                :options="appConfig('weekdays')" />
                        </div>

                        <div class="col-5 form-group">
                            <label>Horário</label>
                            <x-form-input type="select" class="sselect2" name="time"
                                :options="appConfig('class_time')" />
                        </div>

                        <div class="col-12 form-group">
                            <label>Dia da Semana</label>
                            <x-form-input type="select" class="sselect2" name="instructor_id" :options="$instructors" />
                        </div>


                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>

                </form>

                @endif

            </div>
        </div>
    </div>

    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Aulas/Professores
                </h4>
            </div>
            <div class="card-body">



                <table class="table tabsle-sm table-striped datatables w-100">
                    <thead>
                        <tr>

                            <th>Dia</th>
                            <th>Hora</th>
                            <th>Instrutor</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registration->classWeek as $class)
                        <tr>
                            <td>{{ appConfig('weekdays')[$class->weekday] }}</td>
                            <td>{{ $class->time }}</td>
                            <td>
                                {{ $class->instructor->user->name }}
                            </td>
                            <td>
                                Exclui
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table tabsle-sm table-striped datatables w-100">
            <thead>
                <tr>
                    <th>Nº Aula</th>
                    <th>Data</th>
                    <th>Dia</th>
                    <th>Hora</th>
                    <th>Instrutor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registration->classes as $class)
                <tr>
                    <td scope="row">{{ $class->class_order }}º</td>
                    <td>{{ date('d/m/Y', strtotime($class->date)) }}</td>
                    <td>{{ $class->weekdayName }}</td>
                    <td>{{ $class->time }}</td>
                    <td>
                        {{ $class->instructor->user->name }}
                    </td>
                    <td>
                        {!! $class->statusClass !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- Button trigger modal -->





@endsection

@section('outbody')

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
    // function formatState (state) {
    //     if (!state.id) {
    //         return state.text;
    //     }
    //     var baseUrl = "/user/pages/images/flags";
    //     var $state = $(
    //        ' '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>''
    //     );
    //     return $state;
    //     };


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
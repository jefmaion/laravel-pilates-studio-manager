<div class="modal-header bg-whitesmoke p-3">
    <h5 class="modal-title">
        {{ appConfig('classTypes')[$class->type]['label']  }} - {{ appConfig('classStatus')[$class->status]['label']  }}
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span>&times;</span>
    </button>
</div>

<div class="modal-body">
    
    <div class="row">
        <div class="col-12">
            <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                <li class="media">
                    <figure class="avatar mr-2 avatar-xl mr-4">
                        <img src="{{ imageProfile($class->student->user->image) }}" alt="...">
                    </figure>
                    <div class="media-body">
                        <div class="media-title mb-1">
                            <a href="{{ route('registration.show', $class->registration) }}">
                                <h5>
                                    {{ $class->student->user->name }}
                                </h5>
                            </a>
                        </div>

                        <div class="">
                            
                            <div class="mb-2">
                                <i class="fas fa-clock"></i> {{ $class->time }} <span class="mx-1 text-light">|</span>
                                <i class="fas fa-calendar"></i> {{ dateDMY($class->date) }} <span class="mx-1 text-light">|</span>
                                <figure class="avatar mr-2 avatar-xs">
                                    <img src="{{ imageProfile($class->instructor->user->image) }}" alt="...">
                                  </figure> {{ $class->instructor->user->name }}
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-boxes"></i> {{ $class->registration->plan->name }} <span class="mx-1 text-light">|</span>
                                <i class="fa fa-phone"></i> {{ $class->student->user->phone_wpp }} 
                                
                            </div>
                        </div>

                        <div class="media-links mb-2">

                            @if(!$class->hasScheduledReplacementClass)
                            <span class="text-danger">
                                <strong>
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Reposição não agendada
                                </strong>
                            </span>
                            @endif

                            @if($class->type == 'RP')
                            <span class="text-warning">
                                <strong>
                                    <i class="fa fa-info-circle" aria-hidden="true"></i> Reposição do dia {{
                                    dateDMY($class->classRelated->date) }}
                                </strong>
                            </span>
                            @endif
                        </div>

                        <div>
                            

                            @if($class->student->hasInstallmentsToPayToday)
                            <span class="badge badge-pill badge-warning">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Pagar Mensalidade Hoje
                            </span>
                            @endif

                       

                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <ul class="nav nav-tabs nav-justifised" id="myTab2" role="tablist">
        @if($class->student->lastClasses)
        <li class="nav-item">
            <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2" role="tab" aria-controls="home" aria-selected="true">
                <i class="fas fa-calendar-check    "></i>
                Aulas Realizadas
            </a>
        </li>

        @endif

        @if($class->student->registration->lateInstallments->count() > 0)
        <li class="nav-item">
            <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">
                @if($class->student->hasLateInstallments)
                    <i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i>
                    @else
                    <i class="fas fa-money-bill-wave"></i> 
                @endif

                Mensalidades
                
            </a>
        </li>
        @endif

        @if($class->student->evolutions)
        <li class="nav-item">
            <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">
                @if(!$class->evolution && $class->status == 1)
                    <i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i>
                    @else
                    <i class="fas fa-chart-line"></i>
                @endif
                 Evoluções

            </a>
        </li>
        @endif
    </ul>

    <div class="tab-content tab-bordsered" id="myTab3Content">

        <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">
            <table class="table table-sm table-striped datatables w-100" id="table-def">
                <thead class="">
                    <tr>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Instrutor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($class->student->lastClasses as $cls)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($cls->date)) }} {{ date('H:i', strtotime($cls->time)) }}</td>
                        <td>{{ appConfig('classTypes')[$cls->type]['label'] }}</td>
                        <td>
                            <figure class="avatar mr-2 avatar-sm">
                                <img src="{{ imageProfile($cls->instructor->user->image) }}" alt="...">
                              </figure>
                            {{ $cls->instructor->user->nickname }}
                        </td>
                        <td>
                            {!! $cls->statusClass !!}
                   
                       </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
            <table class="table table-sm table-striped datatables w-100" id="table-def">
                <thead class="">
                    <tr>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Forma de Pagamento</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($class->student->registration->lateInstallments as $inst)



                    <tr>
                        <td>{{ date('d/m/Y', strtotime($inst->due_date)) }}</td>
                        <td>R$ {{ USD_BRL($inst->value) }}</td>
                        <td>{{ $inst->paymentMethod->name }}</td>
                        <td>
                            @if($inst->isLate)
                                <a href="{{ route('payable.receive', $inst) }}">{!! $inst->status_label !!}</a>
                            @else
                                {!! $inst->status_label !!}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact-tab2">

            @if(!$class->evolution && $class->status == 1)
                <div class="alert alert-warning" role="alert">
                A evolução desta aula ({{ dateDMY($class->date) }}) ainda não foi registrada!
                <a href="{{ route('evolution.create', $class) }}" class="badge badge-primary">Cadastrar Evolução</a>
                </div>
            @endif

            <div class="form-group">
                <select id="select-evolution" class="form-control" name="" onchange="">
                    @foreach($class->student->evolutions as $evolution)
                    <option value="{{ $evolution->id }}">{{ dateDMY($evolution->classes->date) }} - {{ $evolution->instructor->user->name }}</option>
                    @endforeach
                </select>
            </div>

            @foreach($class->student->evolutions as $evolution)
            <div id="evolution-{{ $evolution->id }}" class="evolutions">

                <p>{{ $evolution->classes->comments }}</p>
                <ul>
                @foreach($evolution->exercices as $exercice)
                
                    {{-- <h6> {{ $exercice->exercice->name }}</h6> --}}
                    
                        <li class="mb-2"><b>{{ $exercice->exercice->name }}: </b>{!! $exercice->comments !!}</li>
                    
                
                @endforeach
            </ul>
                <hr>
                Avaliado por
                
                <span class="font-weight-bold font-13">
                    {{ $evolution->instructor->user->name }}
                </span>
                &nbsp;&nbsp; - {{ $evolution->created_at->diffForHumans()}}

            </div>
            @endforeach

            

            
        </div>

      </div>

{{-- 
    @if(isset($class->student->lastEvol->evolution) && $class->status == 0)

    <div><b>Última Evolução</b> ({{ dateDMY($class->student->lastEvolution()->date) }})</div>
    <hr class="m-0 mb-2">

    {!! $class->student->lastEvol->evolution->evolution !!}

    <div class="my-3">
        @foreach($class->student->lastEvolution()->exercices as $exercice)

        <span class="badge badge-pill badge-light m-1"><small>
                {{ $exercice->exercice->name }}</small></span>
        @endforeach
    </div>

    <small class="text-muted">
        Avaliado por
        <span class="font-weight-bold font-13">
            {{ $class->student->lastEvolution()->instructor->user->name }}
        </span>
        &nbsp;&nbsp; - {{ $class->student->lastEvolution()->updated_at->diffForHumans()}}
    </small>


    @endif

    @if($class->evolution && $class->status == 1)
    <div><b>Evolução da Aula</b></div>
    <hr class="m-0 mb-2">

    {!! $class->evolution->evolution !!}

    <div class="my-3">
        <div>Exercícios/Aparelhos Utilizados: </div>
        @foreach($class->student->lastEvolution()->exercices as $exercice)
        <span class="badge badge-pill badge-light mr-1 mt-1"><small>
                {{ $exercice->exercice->name }}</small>
        </span>
        @endforeach
    </div>

    <small class="text-muted">
        Avaliado por
        <span class="font-weight-bold font-13">
            {{ $class->student->lastEvolution()->instructor->user->name }}
        </span>
        &nbsp;&nbsp; - {{ $class->student->lastEvolution()->updated_at->diffForHumans()}}
    </small>


    @endif --}}




</div>
<div class="modal-footer bg-whitesmoke br">

    <button type="button" class="btn btn-secondary" data-dismiss="modal">
        <i class="fa fa-times-circle" aria-hidden="true"></i>
        Fechar
    </button>

    @if(!$class->hasScheduledReplacementClass)
    <a name="" id="" class="btn btn-success" href="{{ route('class.replacement', $class) }}">
        <i class="fa fa-calendar" aria-hidden="true"></i>
        Agendar Reposição
    </a>
    @endif

    @if(!$class->evolution && $class->status == 1)
    <a name="" id="" class="btn btn-success" href="{{ route('class.replacement', $class) }}">
        <i class="fa fa-calendar" aria-hidden="true"></i>
        Registrar Evolução
    </a>
    @endif

    @if($class->status === 0)

    <a name="" id="" class="btn btn-danger text-white" href="{{ route('class.absense', $class) }}">
        <i class="fa fa-times-circle" aria-hidden="true"></i>
        Registrar Falta
    </a>


    <a name="" id="" class="btn btn-success" href="{{ route('class.presence', $class) }}">
        <i class="fa fa-check-circle" aria-hidden="true"></i>
        Registrar Presença
    </a>

    @endif



</div>


<script>
    $(".datatables").dataTable({...config, ressponsive:false, pageLength: 3, bLengthChange: false,searching: false});
    $(".datatables2").dataTable({...config, ressponsive:false, pageLength: 1, bLengthChange: false});


    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    })

    showEvolution($('#select-evolution').val())

    $('#select-evolution').change(function (e) { 
        e.preventDefault();
        showEvolution($(this).val())
    });

    function showEvolution(id) {
        $('.evolutions').hide();
        $('#evolution-' + id).fadeIn();
    }

</script>
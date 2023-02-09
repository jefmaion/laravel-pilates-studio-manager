<div class="modal-header border-bsottom p-3 text-white bg-{{ appConfig('classStatus')[$class->status]['color'] }}">
    <h5 class="modal-title">

        
        {{ dateExt($class->date) }} 
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
                                <i class="fa fa-phone"></i> {{ $class->student->user->phone_wpp }}
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-clock"></i> {{ $class->time }} <span class="mx-1 text-light">|</span>
                                <i class="fas fa-calendar"></i> {{ dateDMY($class->date) }} <span class="mx-1 text-light">|</span>
                                <i class="fa fa-user-circle"></i> {{ $class->instructor->user->name }}
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
                                    <i class="fa fa-info-circle" aria-hidden="true"></i> Reposição do dia    {{ dateDMY($class->classRelated->date) }}
                                </strong>
                            </span>
                            @endif

                            @if(!$class->evolution && $class->status == 1)
                            <span class="text-danger">
                                <strong>
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Evolução não registrada
                                </strong>
                            </span>
                            @endif


                            
                        </div>
                        
                        <div>

                            <span class="badge badge-pill badge-{{ appConfig('classStatus')[$class->status]['color'] }}">
                                {{ appConfig('classStatus')[$class->status]['label'] }}
                            </span>

                            @if($class->student->hasLateInstallments)
                            <span class="badge badge-pill badge-danger">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Mensalidade(s) Atrasada(s).
                            </span>
                            @endif


                            @if($class->student->hasInstallmentsToPayToday)
                            <span class="badge badge-pill badge-warning">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Pagar Mensalidade Hoje
                            </span>
                            @endif

                            @if($class->comments)
                            <div class="mt-2 text-muted">
                                <b>Comentários: </b> {{ $class->comments }}
                            </div>
                            @endif
                         
                            
                        </div>
                    </div>
                </li>

            </ul>
        </div>

        <div class="col text-rigfht">



        </div>
    </div>




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

        {{-- <p class="text-right">Avaliado por {{ $class->student->lastEvolution()->instructor->user->name }} {{ $class->student->lastEvolution()->updated_at->diffForHumans()}} </p> --}}
        
    @endif




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
    
    <a name="" id="" class="btn btn-danger" href="{{ route('class.absense', $class) }}">
        <i class="fa fa-times-circle" aria-hidden="true"></i>
        Registrar Falta
    </a>

    <a name="" id="" class="btn btn-success" href="{{ route('class.presence', $class) }}">
        <i class="fa fa-check-circle" aria-hidden="true"></i>
        Registrar Presença
    </a>
    
    @endif



</div>
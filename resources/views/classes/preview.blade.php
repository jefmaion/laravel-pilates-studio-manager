<div class="modal-header border-bsottom p-3 bg-whitesmoke">
    <h5 class="modal-title">
        {{ dateExt($class->date) }} - <small> {{ appConfig('classTypes')[$class->type]['label'] }}</small>
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span>&times;</span>
    </button>
    
</div>

<div class="modal-body">
    

    <div class="row">
        <div class="col-8">
            <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                <li class="media">
                    <figure class="avatar mr-2 avatar-xl mr-4">
                        <img src="{{ imageProfile($class->student->user->image) }}" alt="...">

                    </figure>
                    <div class="media-body">


                        <div class="media-title mb-1">
                            <a href="{{ route('student.show', $class->student) }}">
                                <h5> {{ $class->student->user->name }} </h5>
                            </a>
                            {{-- <span class="badge badge-pill p-1 badge-{{ $class->classType }}">{{ $class->type}}</span> --}}
                        </div>

                        <div class="">
                            <div class="mb-2">
                                <i class="fa fa-phone"></i>
                                {{ $class->student->user->phone_wpp }}
                            </div>

                            <div class="mb-2">
                                <i class="fas fa-clock"></i> {{ $class->time }} <span class="mx-1 text-light">|</span>
                                <i class="fas fa-calendar"></i> {{ $class->date }} <span class="mx-1 text-light">|</span>
                                <i class="fa fa-user-circle"></i> {{ $class->instructor->user->name }}
                            </div>

                        </div>

                        
                        <div class="media-links">

                            @if(!$class->hasScheduledReplacementClass)
                            <span class="text-danger">
                                <strong>Atenção</strong> Reposição não agendada
                            </span>
                            @endif
                        </div>
                    </div>
                </li>

            </ul>
        </div>

        <div class="col text-right">

            <span class="badge badge-pill badge-light">
                {{ appConfig('classTypes')[$class->type]['label'] }}



                @if($class->type == 'RP')
                (do dia {{ date('d/m/Y', strtotime($class->classRelated->date)) }})
                @endif


            </span>
            <span class="badge badge-pill badge-light"> {{ appConfig('classStatus')[$class->status]['label'] }}</span>


        </div>
    </div>

    @if($class->student->lastEvolution())

    <div><b>Última Evolução Cadastrada</b></div>

    

    <hr class="m-0 mb-2">

    <div class="my-3">
    @foreach($class->student->lastEvolution()->exercices as $exercice)
        <span class="badge badge-pill badge-primary">{{ $exercice->exercice->name }}</span>
    @endforeach
    </div>
    {!! $class->student->lastEvolution()->evolution !!}

    <p class="text-right">Avaliado por {{ $class->student->lastEvolution()->instructor->user->name }} {{ $class->student->lastEvolution()->updated_at->diffForHumans()}} </p>
    

@endif




</div>
<div class="modal-footer bg-whitessmoke br">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
        <i class="fa fa-times-circle" aria-hidden="true"></i>
        Fechar
    </button>

    @if(!$class->hasScheduledReplacementClass)
    <a name="" id="" class="btn btn-primary" href="{{ route('class.replacement', $class) }}">
        <i class="fa fa-calendar" aria-hidden="true"></i>
        Agendar Reposição
    </a>
    @endif

    @if($class->status === 0)
    <div class="dropdown d-inline mr-2">
        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-times-circle" aria-hidden="true"></i>
            Registrar Falta
        </button>
        <div class="dropdown-menu" x-placement="bottom-start">
            <a class="dropdown-item" href="{{ route('class.absense', [$class, 3]) }}">
                <i class="fa fa-times-circle" aria-hidden="true"></i>
                Falta SEM AVISO
            </a>
            @if($class->type !== 'RP')
            <a class="dropdown-item" href="{{ route('class.absense', [$class, 2]) }}">
                <i class="fa fa-times-circle" aria-hidden="true"></i>
                Falta COM AVISO
            </a>
            @endif
        </div>
    </div>
    <a name="" id="" class="btn btn-success" href="{{ route('class.presence', $class) }}">
        <i class="fa fa-check-circle" aria-hidden="true"></i>
        Registrar Presença
    </a>
    @endif
</div>
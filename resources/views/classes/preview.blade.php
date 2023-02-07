<div class="modal-header">
    <h5 class="modal-title">
        {{ dateExt($class->date) }}

    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">

    {{-- <figure class="avatar mr-2 avatar-xl">
        <img src="assets/img/users/user-1.png" alt="...">
        <img src="assets/img/users/user-5.png" class="avatar-icon" alt="...">
    </figure> --}}


    <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
        <li class="media">
            <figure class="avatar mr-2 avatar-xl mr-4">
                <img src="{{ imageProfile($class->student->user->image) }}" alt="...">
                {{-- <img src="{{ imageProfile($class->instructor->user->image) }}" class="avatar-icon" alt="..."> --}}
            </figure>
            <div class="media-body">


                <div class="media-title mb-1">
                    <a href="{{ route('student.show', $class->student) }}">
                        <h5> {{ $class->student->user->name }} </h5>
                    </a>
                    {{-- <span class="badge badge-pill p-1 badge-{{ $class->classType }}">{{ $class->type }}</span> --}}
                </div>

                <div class="">
                    <div class="mb-2">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        {{ $class->student->user->phone_wpp }} |
                    </div>

                    <div class="mb-2">
                        <i class="fas fa-clock"></i> {{ $class->time }} |
                        <i class="fas fa-calendar"></i> {{ $class->date }}
                    </div>



                    <div class="">
                        <figure class="avatar mr-2 avatar-sm">
                            <img src="{{ imageProfile($class->instructor->user->image) }}" alt="...">
                          </figure>
                          {{-- <i class="fa fa-user-circle" aria-hidden="true"></i> --}}
                        {{ $class->instructor->user->name }}
                    </div>

                    <div class="mt-3">
                        <span class="badge badge-pill badge-light">
                            {{ appConfig('classTypes')[$class->type]['label'] }}



                            @if($class->type == 'RP')
                            (do dia {{  date('d/m/Y', strtotime($class->classRelated->date)) }})
                            @endif


                        </span>
                        <span class="badge badge-pill badge-light"> {{ appConfig('classStatus')[$class->status]['label'] }}</span>



                    </div>
                </div>

                @if(!empty($class->comments))
                <div class="media-description text-muted mt-2">
                    <div><strong>Comentários: </strong>{{ $class->comments }}</div>
                </div>
                @endif
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
<div class="modal-footer bg-whitesmoke br">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

    @if(!$class->hasScheduledReplacementClass)
        <a name="" id="" class="btn btn-primary" href="{{ route('class.replacement', $class) }}">Agendar Reposição</a>
    @endif

    @if($class->status === 0)
    <div class="dropdown d-inline mr-2">
        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Marcar Falta
        </button>
        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
          <a class="dropdown-item" href="{{ route('class.absense', [$class, 3]) }}">Falta</a>
          @if($class->type !== 'RP')
            <a class="dropdown-item" href="{{ route('class.absense', [$class, 2]) }}">Falta com Aviso</a>
          @endif
        </div>
      </div>
        <a name="" id="" class="btn btn-success" href="{{ route('class.presence', $class) }}">Marcar Presença</a>
    @endif
</div>

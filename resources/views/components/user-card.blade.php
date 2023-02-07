<div class="card author-box">
    <div class="card-body">
        <div class="author-box-left">
            <img alt="image" src="{{ imageProfile($user->user->image) }}" class="rounded-circle author-box-picture">
            <div class="clearfix"></div>
            {{-- <a href="" class="btn btn-light mt-3 follow-btn">Trocar Foto</a> --}}
        </div>
        <div class="author-box-details">

            <div class="author-box-name">
                <a href="#"><strong>{{ $user->user->name }}</strong></a>
            </div>

            <div class="author-box-job">
                <ul class="list-inline text-muted">
                    <li class="list-inline-item">
                        <strong><i class="fa fa-birthday-cake" aria-hidden="true"></i></strong> {{ $user->user->age }}
                    </li>
                    
                    <li class="list-inline-item">
                        <strong><i class="fas fa-phone"></i></strong> {{$user->user->phone_wpp }}
                    </li>

                    {{-- <li class="list-inline-item">
                        <strong><i class="fas fa-user"></i></strong> {{ $user->user->cpf }}
                    </li> --}}

                    
                </ul>
            </div>

            <div class="author-box-description">

                @if($user->registration)
                    <span class="badge badge-pill badge-light">{{ $user->registration->plan->name }}</span>
                @endif


            </div>

            <div class="mb-2 mt-3">
                {{ $slot }}
            </div>
        </div>


    </div>
</div>
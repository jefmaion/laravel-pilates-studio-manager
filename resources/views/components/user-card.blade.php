<div class="card author-box flex-fill">
    @if($title)
    <div class="card-header">
        <h4>
            <i class="fa fa-users" aria-hidden="true"></i>
            {{ $title }}
        </h4>
    </div>
    @endif
    <div class="card-body ">
        <div class="author-box-center">
            <img alt="image" src="{{ imageProfile($user->image) }}" heisght="60" class="rounded-circle author-box-picture">
            <div class="clearfix"></div>
            <div class="author-box-name">
                <a href="#">{{ $user->name }}</a>
            </div>
            <div class="author-box-job">Cadastrado {{ $user->created_at->diffForHumans() }}</div>
        </div>
        <div class="text-center">
            <div class="author-box-description">
                <p class="text-muted">
                    {{ $user->phone_wpp }} | {{ $user->phone2 }}
                </p>
            </div>

            <div class="w-100 d-sm-none"></div>
            <div>{{ $slot }}</div>
            
        </div>
    </div>
</div>


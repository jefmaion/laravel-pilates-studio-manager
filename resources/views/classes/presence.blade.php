@extends('layouts.main')

@section('content')
<form action="{{ route('class.presence.store', $class) }}" method="post">
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Marcar Presença
                </h4>
            </div>
            
            <div class="card-body">

                <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">

                    <li class="media">

                        <figure class="avatar mr-2 avatar-xl mr-4">
                            <img src="{{ imageProfile($class->student->user->image) }}" alt="...">
                        </figure>

                        <div class="media-body">

                            <div class="media-title mb-3">
                                <a href="{{ route('student.show', $class->student) }}" class="h5">{{ $class->student->user->name }}</a> 
                                <div class=""></div>
                            </div>

                            <div class="tesxt-time">
                              
                                <div class="mb-2">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    {{ date('d/m/Y', strtotime($class->date)) }} |  
                                    <i class="fas fa-clock"></i>{{ $class->time }}  | 
                                    {{ Config::get('application.classTypes')[$class->type]['label']}}
                                </div>

                                <div class="mb-2">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    {{ $class->instructor->user->name }}
                                </div>
                            </div>
                            
                        </div>
                    </li>
            
                </ul>

                
                @csrf
                <input type="hidden" name="status" value="1">

                <div class="row">
                    <div class="form-group col">
                        <label for="">Professor</label>
                        {{-- <x-form-input type="select" class="select2 class-props"   name="instructor_id" value="{{ $class->instructor_id }}"  :options="$instructors" /> --}}
                        <x-select2-image name="instructor_id" value="{{ $class->instructor_id }}" :options="$instructors" />
                    </div>

                    <div class="col-12 form-group notice">
                        <label for="">Comentários da aula</label>
                        <x-form-input type="textarea" rows="5" name="comments" />
                    </div>

                </div>

                <a name="" id="" class="btn btn-secondary" href="{{ route('class.index') }}" role="button">
                    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                    Voltar
                </a>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle    "></i>
                    Marcar Presença
                </button>
                
                
            </div>
        </div>
    </div>

  
</div>

</form>

@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
@endsection
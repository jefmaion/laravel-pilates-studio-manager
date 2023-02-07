@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-4">
        <div class="card author-box">
            <div class="card-body">
                <form method="POST" action="{{ route('student.profile.store', $student) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="author-box-left">
                        <img alt="image" src="{{ imageProfile($student->user->image) }}" class="rounded-circle author-box-picture">
                        <div class="clearfix"></div>
                    </div>

                    <div class="author-box-details">

                        <div class="author-box-name">
                            Escolha a Imagem
                        </div>

                        <div class="author-box-description">
                            <x-form-input type="file" name="profile_image" />
                        </div>

                    </div>

                    <br>
                    <hr>

                    <a name="" id="" class="btn btn-secondary" href="{{ route('student.show', $student) }}" role="button">
                        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                        Voltar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Enviar Foto
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
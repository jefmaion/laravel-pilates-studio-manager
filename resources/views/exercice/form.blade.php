<div class="row">

    <div class="col-12 form-group">
        <label>Tipo</label>
        <x-form-input type="select" name="type" :options="['A' => 'Aparelho/Acessório',  'E' => 'Exercício']" value="{{ $exercice->type }}" />
    </div>

    <div class="col-12 form-group">
        <label>Nome</label>
        <x-form-input name="name" value="{{ $exercice->name }}" />
    </div>

    

    <div class="col-12 form-group">
        <label>Descrição do Exercicio</label>
        <x-form-input type="textarea" name="description" value="{{ $exercice->description }}" />
    </div>

    

    <div class="col-12 form-group">
        <x-form-input type="switch" name="enabled" label="Ativo" value="{{ $exercice->enabled }}" />
    </div>

    

</div>

<a name="" id="" class="btn btn-secondary" href="{{ route('exercice.index') }}" role="button">
    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
    Voltar
</a>

<button type="submit" class="btn btn-success">
    <i class="fas fa-check-circle"></i>
    Salvar
</button>


@section('scripts')
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.config.js') }}"></script>
@endsection
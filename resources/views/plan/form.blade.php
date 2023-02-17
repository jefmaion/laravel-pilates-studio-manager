<div class="row">

    <div class="col-12 form-group">
        <label>Nome do Plano</label>
        <x-form-input name="name" value="{{ $plan->name }}" />
    </div>

    <div class="col-3 form-group">
        <label>Duração (em meses)</label>
        <x-form-input type="number" name="duration" value="{{ $plan->duration }}" />
    </div>
    <div class="col-3 form-group">
        <label>Aulas por Semana</label>
        <x-form-input type="number" name="class_per_week" value="{{ $plan->class_per_week }}" />
    </div>

    <div class="col-6 form-group">
        <label>Valor</label>
        <x-form-input name="value" class="money" value="{{ $plan->value }}" />
    </div>


    <div class="col-12 form-group">
        <label>Descrição do Plano</label>
        <x-form-input type="textarea" rows="3" name="description" value="{{ $plan->description }}" />
    </div>

    

    
    <div class="col-12 form-group">
        <x-form-input type="switch" name="enabled" label="Ativo" value="{{ $plan->enabled }}" />
    </div>

    

</div>

<a name="" id="" class="btn btn-secondary" href="{{ route('plan.index') }}" role="button">
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
<div class="row">

    <div class="col-3 form-group">
        <label>Data de Vencimento</label>
        <x-form-input type="date" name="due_date" value="{{ $account->due_date }}" />
    </div>

    <div class="col-12 form-group">
        <label>Descrição</label>
        <x-form-input name="description" value="{{ $account->description }}" />
    </div>

    <div class="col-6 form-group">
        <label>Valor</label>
        <x-form-input name="value" class="money" value="{{ $account->value }}" />
    </div>

    <div class="col-12 form-group">
        <x-form-input type="switch" name="status" label="Conta Paga" value="{{ $account->status }}" />
    </div>

</div>

<a name="" id="" class="btn btn-secondary" href="{{ route('payable.index') }}" role="button">
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
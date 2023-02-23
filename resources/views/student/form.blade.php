
<div class="row">

    <div class="col-2 form-group">
        <label>CPF</label>
        <x-form-input name="cpf" class="cpf" value="{{ $student->user->cpf }}" />
        <input type="hidden" name="user" value="{{ $student->user->id }}">
    </div>


    <div class="col-4 form-group">
        <label>Nome</label>
        <x-form-input name="name" value="{{ $student->user->name }}" />
    </div>

    <div class="col-2 form-group">
        <label>Apelido</label>
        <x-form-input name="nickname" value="{{ $student->user->nickname }}" />
    </div>

    <div class="col-2 form-group">
        <label>Data de Nascimento</label>
        <x-form-input type="date" name="birth_date" value="{{ $student->user->birth_date }}" />
    </div>

    <div class="col-2 form-group">
        <label>Sexo</label>
        <x-form-input type="select" name="gender" :options="['M' => 'Masculino',  'F' => 'Feminino']" value="{{ $student->user->gender }}" />
    </div>

    <div class="col-2 form-group">
        <label>CEP</label>
        <x-form-input type="text" class="cep" name="zipcode" value="{{ $student->user->zipcode }}" />
    </div>

    <div class="col-5 form-group">
        <label>Endereço</label>
        <x-form-input type="text" class="viacep-loading" name="address" value="{{ $student->user->address }}" />
    </div>

    <div class="col-2 form-group">
        <label>Nº</label>
        <x-form-input type="text" name="number" value="{{ $student->user->number }}" />
    </div>

    <div class="col-3 form-group">
        <label>Complemento</label>
        <x-form-input type="text" class="viacep-loading" name="complement" value="{{ $student->user->complement }}" />
    </div>

    <div class="col-7 form-group">
        <label>Bairro</label>
        <x-form-input type="text" class="viacep-loading" name="district" value="{{ $student->user->district }}" />
    </div>

    <div class="col-3 form-group">
        <label>Cidade</label>
        <x-form-input type="text" class="viacep-loading" name="city" value="{{ $student->user->city }}" />
    </div>

    <div class="col-2 form-group">
        <label>Estado</label>
        <x-form-input type="text" class="viacep-loading" name="state" value="{{ $student->user->state }}" />
    </div>


    <div class="col-3 form-group">
        <label>Telefone (WhatsApp)</label>
        <x-form-input type="text" class="sp_celphones" name="phone_wpp" value="{{ $student->user->phone_wpp }}" />
    </div>

    <div class="col-3 form-group">
        <label>Telefone Recado</label>
        <x-form-input type="text" class="sp_celphones" name="phone2" value="{{ $student->user->phone2 }}" />
    </div>

    <div class="col-6 form-group">
        <label>E-mail</label>
        <x-form-input type="email" class="viacep-loading" name="email" value="{{ $student->user->email }}" />
    </div>


    <div class="col-12 form-group">
        <label>Observações</label>
        <x-form-input type="textarea" name="comments" value="{{ $student->comments }}" />
    </div>

    <div class="col-12 form-group">
        <x-form-input type="switch" name="enabled" label="Ativo" value="{{ $student->enabled }}" />
    </div>

</div>

<a name="" id="" class="btn btn-secondary" href="{{ route('student.index') }}" role="button">
    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
    Voltar
</a>

<button type="submit" class="btn btn-success">
    <i class="fas fa-check-circle"></i>
    Salvar
</button>

@if(!isset($student->registration))
{{-- <button type="submit" class="btn btn-success">
    <i class="fas fa-check-circle"></i>
    Salvar e Matricular
</button> --}}
@endif

@section('scripts')
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.config.js') }}"></script>
<script>
    $('[name=zipcode]').keyup(function (e) { 
        var zipcode = $(this).val()
        if(zipcode.length < 9) return

        $.ajax({
            type: "get",
            url: "/student/zipcode/" + zipcode,
            dataType: "json",
            beforeSend: function(e){
                $('.viacep-loading').val('...')
            },
            success: function (response) {
                $('.viacep-loading').val('')
                console.log(response)
                if(response.status) {
                    $('[name=address]').val(response.data.logradouro)
                    $('[name=district]').val(response.data.bairro)
                    $('[name=city]').val(response.data.localidade)
                    $('[name=state]').val(response.data.uf)
                    $('[name=number]').focus()
                    return
                }

            }
        });

});
</script>
@endsection
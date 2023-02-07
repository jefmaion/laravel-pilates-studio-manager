<div class="row">
    
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    {{ $title }}
                </h4>
            </div>
            <div class="card-body">
                
                <div class="row">

                    <div class="col-2 form-group">
                        <label>CPF</label>
                        <x-form-input name="cpf" class="cpf" value="{{ $instructor->user->cpf }}" />
                        <input type="hidden" name="user" value="{{ $instructor->user->id }}">
                    </div>
                
                
                    <div class="col-4 form-group">
                        <label>Nome</label>
                        <x-form-input name="name" value="{{ $instructor->user->name }}" />
                    </div>
                
                    <div class="col-2 form-group">
                        <label>Apelido</label>
                        <x-form-input name="nickname" value="{{ $instructor->user->nickname }}" />
                    </div>
                
                    <div class="col-2 form-group">
                        <label>Data de Nascimento</label>
                        <x-form-input type="date" name="birth_date" value="{{ $instructor->user->birth_date }}" />
                    </div>
                
                    <div class="col-2 form-group">
                        <label>Sexo</label>
                        <x-form-input type="select" name="gender" :options="['M' => 'Masculino',  'F' => 'Feminino']"
                            value="{{ $instructor->user->gender }}" />
                    </div>
                
                
                
                    <div class="col-2 form-group">
                        <label>CEP</label>
                        <x-form-input type="text" class="cep" name="zipcode" value="{{ $instructor->user->zipcode }}" />
                    </div>
                
                    <div class="col-6 form-group">
                        <label>Endereço</label>
                        <x-form-input type="text" class="viacep-loading" name="address" value="{{ $instructor->user->address }}" />
                    </div>
                
                    <div class="col-1 form-group">
                        <label>Nº</label>
                        <x-form-input type="text" name="number" value="{{ $instructor->user->number }}" />
                    </div>
                
                    <div class="col-3 form-group">
                        <label>Complemento</label>
                        <x-form-input type="text" class="viacep-loading" name="complement"
                            value="{{ $instructor->user->complement }}" />
                    </div>
                
                    <div class="col-5 form-group">
                        <label>Bairro</label>
                        <x-form-input type="text" class="viacep-loading" name="district" value="{{ $instructor->user->district }}" />
                    </div>
                
                    <div class="col-5 form-group">
                        <label>Cidade</label>
                        <x-form-input type="text" class="viacep-loading" name="city" value="{{ $instructor->user->city }}" />
                    </div>
                
                    <div class="col-2 form-group">
                        <label>Estado</label>
                        <x-form-input type="text" class="viacep-loading" name="state" value="{{ $instructor->user->state }}" />
                    </div>
                
                
                    <div class="col-3 form-group">
                        <label>Telefone (WhatsApp)</label>
                        <x-form-input type="text" class="sp_celphones" name="phone_wpp" value="{{ $instructor->user->phone_wpp }}" />
                    </div>
                
                    <div class="col-3 form-group">
                        <label>Telefone Recado</label>
                        <x-form-input type="text" class="sp_celphones" name="phone2" value="{{ $instructor->user->phone2 }}" />
                    </div>
                
                    <div class="col-6 form-group">
                        <label>E-mail</label>
                        <x-form-input type="email" class="viacep-loading" name="email" value="{{ $instructor->user->email }}" />
                    </div>

                    <div class="col-8 form-group">
                        <label>Formação Profissional</label>
                        <x-form-input type="text" class="" name="profession" value="{{ $instructor->profession }}" />
                    </div>
                
                    <div class="col-4 form-group">
                        <label>Documento da Profissão</label>
                        <x-form-input type="text" class="" name="profession_document" value="{{ $instructor->profession_document }}" />
                    </div>
                
                
                    <div class="col-12 form-group">
                        <label>Observações</label>
                        <x-form-input type="textarea" name="comments" value="{{ $instructor->comments }}" />
                    </div>
                
                
                    
                
                
                    <div class="col-12 form-group">
                        <x-form-input type="switch" name="enabled" label="Ativo" value="{{ $instructor->enabled }}" />
                    </div>
                
                
                </div>
                
                <a name="" id="" class="btn btn-secondary" href="{{ route('instructor.index') }}" role="button">
                    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                    Voltar
                </a>
                
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle"></i>
                    Salvar
                </button>
                
            </div>
        </div>
    </div>
    <div class="col">

        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                    Remuneração
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    
                
                
                    <div class="col-8 form-group">
                        <label>Tipo de Remuneração</label>
                        <x-form-input type="select" name="remunaration_type" :options="['P' => 'Percentual de aula (%) ',  'F' => 'Valor Fixo', 'S' => 'Sócio (%) ']" value="{{ $instructor->remunaration_type }}" />
                    </div>
                
                    <div class="col-4 form-group">
                        <label>Valor</label>
                        <x-form-input type="text" class="" name="remuneration_value" value="{{ $instructor->remuneration_value }}" />
                    </div>
                
                    <div class="col-4 form-group">
                        
                    </div>
                </div>

                <div class="py-4">
                    <p class="clearfix">
                      <span class="float-left">
                        Calcular Remuneração na Falta Do Aluno
                      </span>
                      <span class="float-right text-muted">
                        <x-form-input type="switch" name="calc_on_absense" value="{{ $instructor->calc_on_absense }}" />
                      </span>
                    </p>
                    {{-- <p class="clearfix">
                      <span class="float-left">
                        Phone
                      </span>
                      <span class="float-right text-muted">
                        (0123)123456789
                      </span>
                    </p>
                    <p class="clearfix">
                      <span class="float-left">
                        Mail
                      </span>
                      <span class="float-right text-muted">
                        test@example.com
                      </span>
                    </p>
                    <p class="clearfix">
                      <span class="float-left">
                        Facebook
                      </span>
                      <span class="float-right text-muted">
                        <a href="#">John Deo</a>
                      </span>
                    </p>
                    <p class="clearfix">
                      <span class="float-left">
                        Twitter
                      </span>
                      <span class="float-right text-muted">
                        <a href="#">@johndeo</a>
                      </span>
                    </p> --}}
                  </div>
            </div>
        </div>
        

    </div>
</div>






@section('scripts')
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.config.js') }}"></script>
<script>
    $('[name=zipcode]').keyup(function (e) { 
        var zipcode = $(this).val()
        if(zipcode.length < 9) return

        $.ajax({
            type: "get",
            url: "/instructor/zipcode/" + zipcode,
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

<div class="row">

    <input type="hidden" name="renovation" value="{{ $registration->renovation }}">

    <div class="col-12 form-group form-group-lg">
        <label>Aluno</label>
          <x-select2-image name="student_id" value="{{ $registration->student_id }}" :options="$students" />
    </div>

    <div class="col-3 form-group">
        <label>Inicio das Aulas</label>
        <x-form-input type="date" name="start"  value="{{ date('Y-m-d') }}" />
    </div>

    <div class="col-9 form-group">
        <label>Plano</label>
        <x-form-input type="select" class="select2" name="plan_id" value="{{ $registration->plan_id }}" :options="$plans" />
    </div>

    <div class="col-3 form-group">
        <label>Dia de Vencimento</label>
        <x-form-input type="number" name="due_date" value="{{ $registration->due_date ?? date('d') }}" />
    </div>

    

    <div class="col-3 form-group">
        <label>Valor</label>
        <x-form-input type="text" classs="money" name="value" value="{{ $registration->value }}" />
    </div>

    <div class="col-3 form-group">
        <label>Desconto</label>
        <x-form-input type="number" name="discount" value="{{ $registration->discount }}" />
    </div>

    <div class="col-3 form-group">
        <label>Valor Final</label>
        <x-form-input type="text" classs="money" name="final_value" value="{{ $registration->final_value }}" />
    </div>

    <div class="col-12 form-group">
        <label>Observações</label>
        <x-form-input type="textarea" rows="5" class="sselect2" name="comments"  />
    </div>

    <div class="col-12">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck1" name="isPaid" value="1">
            <label class="custom-control-label" for="customCheck1">Definir como "Pago" a primeira mensalidade</label>
          </div>
    </div>
</div>



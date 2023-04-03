
<div class="row">

    <input type="hidden" name="renovation" value="{{ $registration->renovation }}">

    <div class="col-12 form-group form-group-lg">
        <label>Aluno</label>
          <x-select2-image name="student_id" value="{{ app('request')->input('s') }}" :options="$students" />
    </div>

    <div class="col-2 form-group">
        <label>Modalidade</label>
        <x-form-input type="select" class="select2" name="modality_id" value="{{ $registration->modality_id }}" :options="$modalities" />
    </div>

    <div class="col-2 form-group">
        <label>Tipo do Plano</label>
        <x-form-input type="select" class="select2" name="duration" value="" :options="[1 => 'Mensal', 3 => 'Trimestral']" />
    </div>

    <div class="col-2 form-group">
        <label>Inicio das Aulas</label>
        <x-form-input type="date" name="start"  value="{{ date('Y-m-d') }}" />
    </div>

    <div class="col-2 form-group">
        <label>Dia de Vencto.</label>
        <x-form-input type="number" name="due_date" value="{{ $registration->due_date ?? date('d') }}" />
    </div>

    <div class="col-2 form-group">
        <label>Aulas por Semana</label>
        <x-form-input type="number" classss="money" name="class_per_week" value="" />
    </div>

    
    <div class="col-2 form-group">
        <label>Valor da Mensalidade</label>
        <x-form-input type="text" classs="money" name="value" value="{{ $registration->value }}" />
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



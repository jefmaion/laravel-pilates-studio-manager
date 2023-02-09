<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agenda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3 form-group">
                        <label>Professor</label>
                        <x-form-input type="select" class="calendar-comp"   name="instructor_id" :options="$instructors" />
                    </div>

                    <div class="col-2 form-group">
                        <label>Tipo de Aula</label>
                        <x-form-input type="select" class="calendar-comp" name="type" :options="['AN' => 'Normal', 'RP' => 'Reposicao', 'AE' => 'Experimental']" />
                    </div>

                    <div class="col-2 form-group">
                        <label>Status da Aula</label>
                        <x-form-input type="select" class="calendar-comp" name="status" :options="[0 => 'Agendada', 1 => 'Realizada', 2 => 'Falta Justificada', 3 => 'Falta Sem Aviso']" />
                    </div>

                    <div class="col-5 form-group">
                        <label>Aluno</label>
                        <x-form-input type="select" class="calendar-comp" name="student_id" :options="$students" />
                    </div>
                </div>
                @include('classes.calendar')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
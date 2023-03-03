@csrf
<div class="row">
    <div class="col-8 form-group">
        <label>Dia da Semana</label>
        <x-form-input type="select" class="sselect2" name="weekday" :options="appConfig('weekdays')" />
    </div>
    <div class="col-4 form-group">
        <label>Horário</label>
        <x-form-input type="select" class="seslect2" name="time" :options="appConfig('class_time')" />
    </div>
    <div class="col-12 form-group">
        <label>Professor</label>
        {{-- <x-form-input type="select" class="select2" name="instructor_id" :options="$instructors" /> --}}
        
        {{-- <x-form-input type="select" class="select2-image input-lg" name="student_id" :options="$students" /> --}}
        <x-select2-image name="instructor_id" :options="$instructors" />
        
    </div>
</div>
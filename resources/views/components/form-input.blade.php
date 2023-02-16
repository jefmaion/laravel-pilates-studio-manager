@switch($type)
    @case('textarea')
        <textarea class="form-control {{ $class }} @error($name) is-invalid @enderror" name="{{ $name }}" id="" rows="{{ $rows }}">{{ $value }}</textarea>
        @break

    @case('switch')
        <label class="custom-switch p-0">
            <input type="hidden" class="form-control {{ $class }}" name="{{ $name }}" value="0">
            <input type="checkbox" name="{{ $name }}" class="custom-switch-input" value="1" {{ ($value == 1) ? 'checked' : '' }}>
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">{{ $label }}</span>
        </label>
        @break


    @case('select')
    
        <select class="form-control {{ $class }} @error($nameDot) is-invalid @enderror" name="{{ $name }}" {{ $multiple }}>
            <option></option>
            @if(isset($options))
                @foreach($options as $key => $option)
                    <option value="{{ $key }}" {{ ((string) $key === (string) $value) ? 'selected' : ''  }}>{{ $option }}</option>
                @endforeach
            @endif
        </select>
                
       
        @break

    @default
        <input type="{{ $type }}" class="form-control {{ $class }} @error($name) is-invalid @enderror" name="{{ $name }}" id="" value="{{ $value }}">
@endswitch

@if($errors->has($name))
    <div class="invalid-feedback">
        {{ $errors->first($name) }}
    </div>
@endif


<select class="form-control select2-image {{ $class }} @error($nameDot) is-invalid @enderror" name="{{ $name }}" {{ $multiple }}>
    <option></option>
    @if(isset($options))
        @foreach($options as $option)
            <option 
                data-image="{{ $option['image'] ?? '' }}" 
                value="{{ $option['id'] }}" {{ $option['selected']  }}
            >
                {{ $option['label'] }}
           </option>
        @endforeach
    @endif
</select>

@if($errors->has($name))
    <div class="invalid-feedback">
        {{ $errors->first($name) }}
    </div>
@endif
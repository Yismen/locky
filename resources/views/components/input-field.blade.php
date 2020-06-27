    <label for="{{ $fieldName }}">
        {{ $labelName }}
        @if ((bool)$required == true)
            <span class="text-danger" title="This field is required"> **</span>
        @endif
    </label>
    <input type="{{ $type ?? 'text' }}"
        class="form-control @error($fieldName) is-invalid @enderror" 
        name="{{ $fieldName }}" 
        id="{{ $fieldName }}" 
        aria-describedby="{{ $fieldName }}"
        value="{{ $fieldValue }}"
        @if ((bool)$required == true)
            required
        @endif
    >   
    @error($fieldName)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
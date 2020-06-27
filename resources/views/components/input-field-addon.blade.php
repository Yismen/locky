<label for="{{ $fieldName }}">
    {{ $labelName }}
    @if ((bool)$required == true)
        <span class="text-danger" title="This field is required"> **</span>
    @endif
</label>

<div class="input-group mb-3">
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
    <div class="input-group-append">
        <button  {{ $attributes->merge(['class' => 'btn ' . $btnClass]) }} type="submit">{{ $buttonAction }}</button>
    </div> 
    
    @error($fieldName)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror 
</div>


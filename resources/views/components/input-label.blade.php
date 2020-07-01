<label for="{{ $fieldName }}">
    {{ $label }}
    @isset($required)
        @if ((bool)$required == true)
            <span class="text-danger" title="This field is required"> **</span>
        @endif
    @endisset
</label>
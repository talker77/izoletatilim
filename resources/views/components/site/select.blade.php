<label for="id_{{ $name }}">{{ $label }}</label>
<select name="{{ $name }}" id="id_{{ $name }}"
        class="{{ $attributes['class'] ?? 'form-control' }}" {{ $attributes }}>
    @if(!isset($attributes['nohint']))
        <option value="">Lütfen Seçiniz</option>
    @endif
    @foreach($options as $option)
        <option
            value="{{ $option[$key] }}" {{ old($name,$value) == $option[$key] ? 'selected' : '' }}> {{ $option[$optionValue] }}</option>
    @endforeach
</select>

<div @class(['required' => $attributes->get('required'), 'two wide field', 'error' => $errors->get($attributes->get('id') ?? 'parcelas')])>
    <label for="{{$attributes->get('id') ?? 'parcelas'}}">{{ $attributes->get('label') ?? 'Parcelas' }}</label>
    <input type="number" name="{{$attributes->get('name') ?? 'parcelas'}}" id="{{$attributes->get('id') ?? 'parcelas'}}" step="1" {{ $attributes->except('label', 'min', 'step', 'name', 'id') }} min="{{ $attributes->get('min') ?? 2 }}}">
    @error($attributes->get('id') ?? 'parcelas')
        <x-message.input-error :message="$message" />
    @enderror
</div>

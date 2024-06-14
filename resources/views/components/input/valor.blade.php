<div @class(['required' => $attributes->get('required'), 'two wide field', 'error' => $errors->get($attributes->get('id') ?? 'valor')])>
    <label for="{{$attributes->get('id') ?? 'valor'}}">{{ $attributes->get('label') ?? 'Valor'}}</label>
    <input type="number" name="{{$attributes->get('name') ?? 'valor'}}" id="{{$attributes->get('id') ?? 'valor'}}" step="0.01" {{ $attributes->except('name', 'id', 'step', 'label') }}>
    @error($attributes->get('id') ?? 'valor')
        <x-message.input-error :message="$message" />
    @enderror
</div>

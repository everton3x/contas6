<div @class(['required' => $attributes->get('required'), 'four wide field', 'error' => $errors->get($attributes->get('id') ?? 'localizador')])>
    <label for="{{$attributes->get('id') ?? 'localizador'}}">Localizador</label>
    <input type="text" name="{{$attributes->get('name') ?? 'localizador'}}" id="{{$attributes->get('id') ?? 'localizador'}}" {{ $attributes->except('label', 'id', 'name') }} list="localizadores">
    @error($attributes->get('id') ?? 'localizador')
        <x-message.input-error :message="$message" />
    @enderror
    <datalist id="localizadores">
        @foreach ($localizadores as $localizador)
        <option value="{{ $localizador->localizador }}">
        @endforeach
    </datalist>
</div>

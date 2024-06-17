<div @class(['required' => $attributes->get('required'), 'four wide' => !$agent->isMobile(),'field', 'error' => $errors->get($attributes->get('id') ?? 'agrupador')])>
    <label for="{{$attributes->get('id') ?? 'agrupador'}}">Agrupador</label>
    <input type="text" name="{{$attributes->get('name') ?? 'agrupador'}}" id="{{$attributes->get('id') ?? 'agrupador'}}" {{ $attributes->except('label', 'name', 'id') }} list="agrupadores">
    @error($attributes->get('id') ?? 'agrupador')
        <x-message.input-error :message="$message" />
    @enderror
    <datalist id="agrupadores">
        @foreach ($agrupadores as $agrupador)
        <option value="{{ $agrupador->agrupador }}">
        @endforeach
    </datalist>
</div>

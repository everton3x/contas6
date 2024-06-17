<div @class(['required' => $attributes->get('required'), 'two  wide' => !$agent->isMobile(),'field', 'error' => $errors->get($attributes->get('id') ?? 'vencimento')])>
    <label for="{{$attributes->get('id') ?? 'vencimento'}}">{{ $attributes->get('label') ?? 'Vencimento'}}</label>
    <input type="date" name="{{$attributes->get('name') ?? 'vencimento'}}" id="{{$attributes->get('id') ?? 'vencimento'}}" {{ $attributes->except('label', 'name', 'id') }}>
    @error($attributes->get('id') ?? 'vencimento')
        <x-message.input-error :message="$message" />
    @enderror
</div>

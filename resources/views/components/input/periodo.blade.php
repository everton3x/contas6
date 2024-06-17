<div @class(['required' => $attributes->get('required'),  'three wide' => !$agent->isMobile(),'field', 'error' => $errors->get($attributes->get('id') ?? 'periodo')])>
    <label for="{{ $attributes->get('id') ?? 'periodo' }}">{{ $label ?? 'Período'}}</label>
    <input type="month" name="{{ $attributes->get('name') ?? 'periodo' }}" id="{{ $attributes->get('id') ?? 'periodo' }}" {{ $attributes->except('label', 'name', 'id') }}>
    @error($attributes->get('id') ?? 'periodo')
        <x-message.input-error :message="$message" />
    @enderror
</div>

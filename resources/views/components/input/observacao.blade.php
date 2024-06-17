<div @class(['required' => $attributes->get('required'), 'five wide' => !$agent->isMobile(),'field', 'error' => $errors->get($attributes->get('id') ?? 'observacao')])>
    <label for="{{$attributes->get('id') ?? 'observacao'}}">{{$attributes->get('label') ?? 'Observação'}}</label>
    <input type="text" name="{{$attributes->get('name') ?? 'observacao'}}" id="{{$attributes->get('id') ?? 'observacao'}}" {{ $attributes->except('id', 'name', 'label') }}>
    @error($attributes->get('id') ?? 'observacao')
        <x-message.input-error :message="$message" />
    @enderror
</div>

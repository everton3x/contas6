<div @class(['required' => $attributes->get('required'), 'five wide' => !$agent->isMobile(),'field', 'error' => $errors->get($attributes->get('id') ?? 'descricao')])>
    <label for="{{$attributes->get('id') ?? 'descricao'}}">Descrição</label>
    <input type="text" name="{{$attributes->get('name') ?? 'descricao'}}" id="{{$attributes->get('id') ?? 'descricao'}}" {{ $attributes->except('name', 'id') }}>
    @error($attributes->get('id') ?? 'descricao')
        <x-message.input-error :message="$message" />
    @enderror
</div>

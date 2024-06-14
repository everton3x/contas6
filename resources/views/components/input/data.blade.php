<div @class(['required' => $attributes->get('required'), 'three wide field', 'error' => $errors->get($attributes->get('id') ?? 'data')])>
    <label for="{{$attributes->get('id') ?? 'data'}}">{{$attributes->get('label') ?? 'Data'}}</label>
    <input type="date" name="{{$attributes->get('name') ?? 'data'}}" id="{{$attributes->get('id') ?? 'data'}}" {{ $attributes->except('id', 'name', 'label') }}>
    @error($attributes->get('id') ?? 'data')
        <x-message.input-error :message="$message" />
    @enderror
</div>

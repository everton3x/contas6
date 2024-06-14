<div @class(['required' => $attributes->get('required'), 'three wide field', 'error' => $errors->get($attributes->get('id') ?? 'mp')])>
    <label for="{{$attributes->get('id') ?? 'mp'}}">Meio de Pagamento</label>
    <input type="text" name="{{$attributes->get('name') ?? 'mp'}}" id="{{$attributes->get('id') ?? 'mp'}}" list="mps" {{ $attributes->except('id', 'name') }}>
    @error($attributes->get('id') ?? 'mp')
        <x-message.input-error :message="$message" />
    @enderror
    <datalist id="mps">
        @foreach ($mps as $mp)
        <option value="{{ $mp->mp }}">
        @endforeach
    </datalist>
</div>

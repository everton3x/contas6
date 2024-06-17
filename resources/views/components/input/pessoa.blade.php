<div @class(['required' => $attributes->get('required'), 'three wide' => !$agent->isMobile(),'field', 'error' => $errors->get($attributes->get('id'))])>
    <label for="{{$attributes->get('id')}}">{{$attributes->get('label')}}</label>
    <input type="text" name="{{$attributes->get('name')}}" id="{{$attributes->get('id')}}" list="pessoas" {{ $attributes->except('id', 'name', 'label') }}>
    @error($attributes->get('id'))
        <x-message.input-error :message="$message" />
    @enderror
    <datalist id="pessoas">
        @foreach ($pessoas as $pessoa)
        <option value="{{ $pessoa->pessoa }}">
        @endforeach
    </datalist>
</div>

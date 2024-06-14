<div @class([
    'required' => $attributes->get('required'),
    'inline fields',
    'error' => $errors->get('tipo_valor'),
])>
    <label for="tipo_valor">Tipo do valor:</label>
    <div class="field">
        <div class="ui radio checkbox">
            <input type="radio" name="tipo_valor" id="tipo_valor" value="total" @class(['hidden', 'checked' => $isChecked('total')]) {{ $attributes }}>
            <label>Total</label>
        </div>
    </div>
    <div class="field">
        <div class="ui radio checkbox">
            <input type="radio" name="tipo_valor" id="tipo_valor" value="parcela" @class(['hidden', 'checked' => $isChecked('parcela')]) {{ $attributes }}>
            <label>Parcela</label>
        </div>
    </div>
    @error('tipo_valor')
        <x-message.input-error :message="$message" />
    @enderror
</div>

<script type="module">
    $('.ui.radio.checkbox')
        .checkbox();
</script>

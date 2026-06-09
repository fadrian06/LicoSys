@props(['error' => ''])

<div
  x-data="{
    valid: !'{{ $error }}',
  }"
  class="form-floating">
  <input
    @keydown="valid = $el.checkValidity();"
    placeholder=""
    :class="valid === false ? 'is-invalid' : ''"
    {{ $attributes->merge(['class' => 'form-control']) }} />
  <label>{{ $slot }}</label>
  <strong class="invalid-feedback">{{ $error }}</strong>
</div>

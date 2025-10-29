<x-guest-layout>
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <x-inputs.floating
      name="name"
      :value="old('name')"
      required
      autofocus
      autocomplete="name"
      :error="$errors->get('name')[0] ?? ''">
      Nombre
    </x-inputs.floating>

    <!-- Email Address -->
    <x-inputs.floating
      class="my-4"
      type="email"
      name="email"
      :value="old('email')"
      required
      autocomplete="username"
      error="{{ $errors->get('email')[0] ?? '' }}">
      Correo electrónico
    </x-inputs.floating>

    <!-- Password -->
    <x-inputs.floating
      class="my-4"
      type="password"
      name="password"
      required
      autocomplete="new-password"
      error="{{ $errors->get('password')[0] ?? '' }}">
      Contraseña
    </x-inputs.floating>

    <x-inputs.floating
      class="my-4"
      type="password"
      name="password_confirmation"
      required
      autocomplete="new-password"
      error="{{ $errors->get('password_confirmation')[0] ?? '' }}">
      Confirmar contraseña
    </x-inputs.floating>

    <div class="d-flex align-items-center justify-content-end gap-4">
      <a href="{{ route('login') }}">¿Ya estás registrado?</a>
      <x-primary-button>Registrarse</x-primary-button>
    </div>
  </form>
</x-guest-layout>

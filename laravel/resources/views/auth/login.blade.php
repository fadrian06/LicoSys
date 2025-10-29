<x-guest-layout>
  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    <x-inputs.floating
      type="email"
      name="email"
      :value="old('email')"
      required
      autofocus
      autocomplete="username"
      :error="$errors->get('email')[0] ?? ''">
      Correo electrónico
    </x-inputs.floating>

    <!-- Password -->
    <x-inputs.floating
      type="password"
      name="password"
      required
      autocomplete="current-password"
      :error="$errors->get('password')[0] ?? ''"
      class="my-4">
      Contraseña
    </x-inputs.floating>

    <div class="d-flex align-items-center justify-content-end gap-4">
      <a href="{{ route('register') }}">¿No te has registrado?</a>
      <x-primary-button>Ingresar</x-primary-button>
    </div>
  </form>
</x-guest-layout>

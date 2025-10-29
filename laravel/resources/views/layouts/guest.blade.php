<x-layouts.base>
  <body
    class="h-100 d-flex flex-column justify-content-md-center align-items-center gap-5 pt-5 pt-md-0"
    style="
      background-image: url('./wallhaven-eor76o.jpg');
      background-position: center;
      background-size: cover;
      background-attachment: fixed;
    ">
    <button
      class="btn position-absolute top-0 right-0 m-1"
      :class="`btn-${theme}`"
      @click="toggleTheme">
      Turn
      <span x-text="theme === 'dark' ? 'on' : 'off'"></span>
      the lights
      <span
        class="bi"
        :class="`bi-${theme === 'dark' ? 'lamp' : 'lamp-fill'}`">
      </span>
    </button>
    <a href="./" class="p-3 rounded-circle shadow-lg" :class="`bg-${theme}`">
      <x-application-logo class="w-20" />
    </a>

    <main class="col-lg-4">
      <div class="card card-body border-0 shadow-lg rounded-5">
        {{ $slot }}
      </div>
    </main>
  </body>
</x-layouts.base>

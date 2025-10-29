<!doctype html>
<html
  class="h-100"
  lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  x-data="{
    theme: {{ $_SESSION['theme'] ?? 'undefined' }} || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),
    toggleTheme() {
      this.theme = this.theme === 'dark' ? 'light' : 'dark';
    },
  }"
  x-effect="fetch(`./preferences/theme/${theme}`)"
  data-bs-theme="{{ $_SESSION['theme'] ?? 'light' }}"
  :data-bs-theme="theme">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <base href="{{ str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) }}" />
    <link rel="icon" href="./favicon.png" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
      href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
      rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  {{ $slot }}
</html>

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Editar Producto') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <form
            method="POST"
            action="{{ route('products.update', $product) }}"
            x-data='{
              product: @json($product),
            }'
            x-effect="product.name = product.name.toUpperCase()">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div class="mt-4">
              <x-input-label for="name" :value="__('Nombre del Producto')" />
              <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="$product->name"
                required
                x-model="product.name" />
              <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Product capacity -->
            <div class="mt-4">
              <x-input-label
                for="capacity"
                :value="__('Capacidad del Producto')" />
              <x-text-input
                id="capacity"
                class="block mt-1 w-full"
                type="number"
                name="capacity"
                :value="$product->capacity"
                required
                min="0"
                step=".01" />
              <x-input-error
                :messages="$errors->get('capacity')"
                class="mt-2" />
            </div>

            <!-- Product Price per Unit -->
            <div class="mt-4">
              <x-input-label
                for="unit_price"
                :value="__('Precio por Unidad')" />
              <x-text-input
                id="unit_price"
                class="block mt-1 w-full"
                type="number"
                step=".01"
                name="unit_price"
                :value="$product->unit_price" />
              <x-input-error
                :messages="$errors->get('unit_price')"
                class="mt-2" />
            </div>

            <!-- Revenue, from 0 to 100 percent -->
            <div class="mt-4">
              <x-input-label for="revenue" :value="__('% Ganancia')" />
              <x-text-input
                id="revenue"
                class="block mt-1 w-full"
                type="number"
                name="revenue"
                :value="$product->revenue"
                required
                step=".01"
                min="0"
                max="100" />
              <x-input-error :messages="$errors->get('revenue')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
              <x-primary-button class="ms-3">
                {{ __('Actualizar Producto') }}
              </x-primary-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

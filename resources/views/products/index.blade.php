@use(Illuminate\Support\Facades\Auth)

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Productos') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div
          class="p-6 text-gray-900"
          x-data='{
            bcvTax: {{ Auth::user()->bcv_tax ?? 'undefined' }},
            products: @json($products),
            productName: "",
            get filteredProducts() {
              if (!this.productName) {
                return this.products;
              }

              return this.products.filter(product => product.name.toLowerCase().includes(this.productName.toLowerCase()));
            },
            currentBcvTax: undefined,
            currentDate: "",
          }'
          x-init="
            axios.get('https://pydolarve.org/api/v2/tipo-cambio')
              .then(response => {
                currentDate = response.data.datetime.date;
                currentBcvTax = Number(response.data.monitors.usd.price);
                bcvTax ||= currentBcvTax;
              })
          "
          x-effect="
            axios.get(`./preferences/taxes/bcv/${bcvTax || 0}`);
          ">
          <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Lista de Productos</h1>
            <a href="{{ route('products.create') }}"
              class="btn btn-primary fw-bold px-4 py-2 rounded hover:bg-blue-600">
              Crear Producto
            </a>
          </div>

          <div class="mb-4">
            <dl>
              <dt class="text-sm font-medium text-gray-700">
                Valor actual de la tasa BCV:
              </dt>
              <dd
                class="text-sm text-gray-900"
                x-text="`${currentBcvTax ? currentBcvTax.toFixed(2) : 'No definido'} (${currentDate})`">
              </dd>
            </dl>

            <x-input-label for="bcvTax" :value="__('Tasa BCV')" />
            <x-text-input
              id="bcvTax"
              class="block mt-1 w-full"
              type="number"
              x-model="bcvTax"
              step=".01" />
          </div>

          @if($products->isEmpty())
          <p>No hay productos disponibles.</p>
          @else
          <div class="mb-4">
            <x-input-label for="productName" :value="__('Buscar Producto')" />
            <x-text-input
              id="productName"
              class="block mt-1 w-full"
              type="search"
              x-model="productName"
              placeholder="Buscar por nombre..." />
          </div>

          <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
              <thead class="text-nowrap">
                <tr>
                  <th>Nombre</th>
                  <th>$</th>
                  <th>% Ganacia</th>
                  <th>BCV</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <template x-for="product in filteredProducts" :key="product.id">
                  <tr
                    x-data="{
                      get revenueFactor() {
                        return (product.revenue / 100) + 1;
                      },
                      get productCapacity() {
                        return product.capacity % 1 !== 0
                          ? `${product.capacity.toFixed(2)}L`
                          : `${product.capacity}L`;
                      }
                    }">
                    <td x-text="`${product.name} ${productCapacity}`"></td>
                    <td x-text="product.unit_price"></td>
                    <td x-text="product.revenue"></td>
                    <td
                      x-text="(product.unit_price * (bcvTax || 0) * revenueFactor).toFixed(2)">
                    </td>
                    <td>
                      <form
                        :action="`./products/${product.id}`"
                        method="POST"
                        class="btn-group">
                        @csrf
                        @method('DELETE')
                        <a
                          :href="`./products/${product.id}/edit`"
                          class="btn btn-primary">
                          Editar
                        </a>
                        <button
                          type="submit"
                          class="btn btn-danger">
                          Eliminar
                        </button>
                      </form>
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

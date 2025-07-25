<!-- Modal de Edição de Restaurante -->
@foreach($restaurants as $restaurant)
  <div id="edit-modal-{{ $restaurant->id }}" tabindex="-1" aria-hidden="true"
       class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-full max-h-full bg-black/50">
    <div class="relative w-full max-w-2xl max-h-full mx-auto mt-20">
      <div class="relative bg-white rounded-lg shadow dark:bg-zinc-800">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t dark:border-zinc-700">
          <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">
            Editar Restaurante
          </h3>
          <button type="button"
                  class="text-zinc-400 hover:text-zinc-900 dark:hover:text-white p-1.5 rounded-lg"
                  data-modal-hide="edit-modal-{{ $restaurant->id }}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"/>
            </svg>
          </button>
        </div>

        <div class="p-6 space-y-6">
          <form action="{{ route('restaurants.update', $restaurant) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
              <label for="name-{{ $restaurant->id }}" class="block mb-1 font-medium text-zinc-700 dark:text-white">Nome do Restaurante *</label>
              <input type="text" name="name" id="name-{{ $restaurant->id }}" value="{{ $restaurant->name }}" placeholder="Restaurante" required
                     class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
            </div>
            <div>
              <label for="cnpj-{{ $restaurant->id }}" class="block mb-1 font-medium text-zinc-700 dark:text-white">CNPJ</label>
              <input type="text" name="cnpj" id="cnpj-{{ $restaurant->id }}" maxlength="18"
                     value="{{ $restaurant->cnpj }}"
                     class="cnpj-mask mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"
                     placeholder="00.000.000/0000-00">
            </div>

            <div>
              <label for="zip_code-{{ $restaurant->id }}" class="block mb-1 font-medium text-zinc-700 dark:text-white">CEP</label>
              <input type="text" name="zip_code" id="zip_code-{{ $restaurant->id }}" maxlength="9"
                     value="{{ $restaurant->zip_code }}" placeholder="00000-000"
                     class="cep-mask mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
            </div>

            <div>
              <label for="street-{{ $restaurant->id }}" class="block mb-1 font-medium text-zinc-700 dark:text-white">Rua</label>
              <input type="text" name="street" id="street-{{ $restaurant->id }}" value="{{ $restaurant->street }}" placeholder="Rua"
                     class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="number-{{ $restaurant->id }}" class="block mb-1 font-medium text-zinc-700 dark:text-white">Número</label>
                <input type="text" name="number" id="number-{{ $restaurant->id }}" value="{{ $restaurant->number }}" placeholder="000"
                       class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
              </div>

              <div>
                <label for="complement-{{ $restaurant->id }}" class="block mb-1 font-medium text-zinc-700 dark:text-white">Complemento</label>
                <input type="text" name="complement" id="complement-{{ $restaurant->id }}" value="{{ $restaurant->complement }}" placeholder="Complemento"
                       class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
              </div>
            </div>

            <div>
              <label for="neighborhood-{{ $restaurant->id }}" class="block mb-1 font-medium text-zinc-700 dark:text-white">Bairro</label>
              <input type="text" name="neighborhood" id="neighborhood-{{ $restaurant->id }}" value="{{ $restaurant->neighborhood }}" placeholder="Bairro"
                     class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="city-{{ $restaurant->id }}" class="block mb-1 font-medium text-zinc-700 dark:text-white">Cidade</label>
                <input type="text" name="city" id="city-{{ $restaurant->id }}" value="{{ $restaurant->city }}" placeholder="Cidade"
                       class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
              </div>

              <div>
                <label for="state-{{ $restaurant->id }}" class="block mb-1 font-medium text-zinc-700 dark:text-white">Estado (UF)</label>
                <input type="text" name="state" id="state-{{ $restaurant->id }}" value="{{ $restaurant->state }}" maxlength="2" placeholder="UF"
                       class="uppercase mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
              </div>
            </div>

            <div class="flex items-center">
              <input type="checkbox" name="is_active" id="is_active-{{ $restaurant->id }}" value="1"
                     class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600"
                  {{ $restaurant->is_active ? 'checked' : '' }}>
              <label for="is_active-{{ $restaurant->id }}" class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">Ativo</label>
            </div>

            <div>
              <label for="user_id-{{ $restaurant->id }}" class="block mb-1 font-medium text-zinc-700 dark:text-white">Usuário Responsável</label>
              <select name="user_id" id="user_id-{{ $restaurant->id }}" required
                      class="w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                <option value="">Selecione um usuário</option>
                @foreach ($users as $user)
                  <option value="{{ $user->id }}"
                      {{ $restaurant->users->first()?->id === $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                  </option>
                @endforeach
              </select>
            </div>

            <div class="pt-4">
              <button type="submit"
                      class="w-full bg-zinc-600 hover:bg-zinc-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                Atualizar Restaurante
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endforeach

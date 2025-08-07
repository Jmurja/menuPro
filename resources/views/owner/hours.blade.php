<x-layouts.app :title="'Horários de Funcionamento - ' . $restaurant->name">
    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('my_restaurants.show', $restaurant) }}" class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">
                    Horários de Funcionamento
                </h1>
            </div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Configure os horários de funcionamento para {{ $restaurant->name }}.
            </p>

            @if (session('success'))
                <div class="mt-4 px-4 py-3 rounded-lg bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200 shadow-sm border border-green-200 dark:border-green-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 p-4 bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200 rounded-lg shadow-sm border border-red-200 dark:border-red-800">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Por favor, corrija os seguintes erros:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm ml-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
            <form action="{{ route('restaurant.hours.update', $restaurant) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    @foreach($hours->sortBy('day_of_week') as $index => $hour)
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-700/30 rounded-lg border border-zinc-200 dark:border-zinc-700">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="days[{{ $index }}][day_of_week]" value="{{ $hour->day_of_week }}">

                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_open_{{ $hour->day_of_week }}" name="days[{{ $index }}][is_open]" value="1"
                                            {{ $hour->is_open ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="is_open_{{ $hour->day_of_week }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Aberto
                                        </label>
                                    </div>

                                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $hour->day_name }}</h3>
                                </div>

                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4"
                                    id="time_fields_{{ $hour->day_of_week }}"
                                    style="{{ $hour->is_open ? '' : 'opacity: 0.5;' }}">
                                    <div>
                                        <label for="opening_time_{{ $hour->day_of_week }}" class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">
                                            Horário de Abertura
                                        </label>
                                        <input type="time"
                                            id="opening_time_{{ $hour->day_of_week }}"
                                            name="days[{{ $index }}][opening_time]"
                                            value="{{ $hour->opening_time ? date('H:i', strtotime($hour->opening_time)) : '08:00' }}"
                                            class="bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 text-zinc-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                            {{ $hour->is_open ? '' : 'disabled' }}>
                                    </div>

                                    <div>
                                        <label for="closing_time_{{ $hour->day_of_week }}" class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">
                                            Horário de Fechamento
                                        </label>
                                        <input type="time"
                                            id="closing_time_{{ $hour->day_of_week }}"
                                            name="days[{{ $index }}][closing_time]"
                                            value="{{ $hour->closing_time ? date('H:i', strtotime($hour->closing_time)) : '18:00' }}"
                                            class="bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 text-zinc-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                            {{ $hour->is_open ? '' : 'disabled' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors">
                            Salvar Horários
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Enable/disable time fields based on checkbox state
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="days"]');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const dayOfWeek = this.id.split('_').pop();
                    const timeFields = document.getElementById(`time_fields_${dayOfWeek}`);
                    const inputs = timeFields.querySelectorAll('input[type="time"]');

                    if (this.checked) {
                        timeFields.style.opacity = '1';
                        inputs.forEach(input => input.disabled = false);
                    } else {
                        timeFields.style.opacity = '0.5';
                        inputs.forEach(input => input.disabled = true);
                    }
                });
            });
        });
    </script>
</x-layouts.app>

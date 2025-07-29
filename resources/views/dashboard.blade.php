<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Catálogo de Turmas Disponíveis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Filtrar Turmas</h3>
                    <form action="{{ route('dashboard') }}" method="GET" class="mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                            {{-- CAMPO DE BUSCA POR DISCIPLINA COM AUTOCOMPLETE --}}
                            <div x-data="{ query: '{{ request('search_subject', '') }}', results: [], open: false }" class="relative">
                                <label for="search_subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome da Disciplina</label>
                                <input type="text" name="search_subject" id="search_subject"
                                    x-model="query"
                                    @input.debounce.300ms="fetch('{{ route('subjects.search') }}?query=' + query).then(res => res.json()).then(data => { results = data; open = true })"
                                    @click.away="open = false"
                                    autocomplete="off"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-white text-black">

                                {{-- Dropdown de resultados do autocomplete --}}
                                <div x-show="open && results.length > 0" class="absolute z-10 w-full bg-white rounded-md shadow-lg mt-1">
                                    <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                        <template x-for="subject in results" :key="subject.id">
                                            <li @click="query = subject.name; open = false" class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white">
                                                <span x-text="subject.name" class="font-normal block truncate"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>

                            {{-- DROPDOWN DE PROFESSORES (CORRIGIDO) --}}
                            <div>
                                <label for="search_teacher" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Professor</label>
                                <select name="search_teacher" id="search_teacher" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-white text-black">
                                    <option value="">Todos</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ request('search_teacher') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- DROPDOWN DE DIAS DA SEMANA (CORRIGIDO) --}}
                            <div>
                                <label for="search_day" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dia da Semana</label>
                                <select name="search_day" id="search_day" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-white text-black">
                                    <option value="">Todos</option>
                                    <option value="segunda" {{ request('search_day') == 'segunda' ? 'selected' : '' }}>Segunda-feira</option>
                                    <option value="terca" {{ request('search_day') == 'terca' ? 'selected' : '' }}>Terça-feira</option>
                                    <option value="quarta" {{ request('search_day') == 'quarta' ? 'selected' : '' }}>Quarta-feira</option>
                                    <option value="quinta" {{ request('search_day') == 'quinta' ? 'selected' : '' }}>Quinta-feira</option>
                                    <option value="sexta" {{ request('search_day') == 'sexta' ? 'selected' : '' }}>Sexta-feira</option>
                                </select>
                            </div>

                            {{-- Botões --}}
                            <div class="flex items-end gap-2">
                                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md">Pesquisar</button>
                                <a href="{{ route('dashboard') }}" class="w-full text-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg shadow-md">Limpar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- 👇 A LISTA DE RESULTADOS (PARTE FALTANTE) COMEÇA AQUI 👇 --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @forelse ($schedules as $schedule)
                        <div class="flex flex-col md:flex-row justify-between items-center p-4 border-b dark:border-gray-700">
                            <div>
                                <p class="font-bold text-lg">{{ $schedule->subject->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $schedule->teacher->name }} - {{ ucfirst($schedule->day_of_week) }}s ({{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }})
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                @php
                                    // Acessa a matrícula específica para esta turma
                                    $enrollment = $enrollments->get($schedule->id);
                                @endphp

                                @if($enrollment)
                                    @if($enrollment->pivot->status == 'pending')
                                        <span class="px-4 py-2 text-sm font-medium text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300 rounded-lg">Pendente</span>
                                    @elseif($enrollment->pivot->status == 'approved')
                                        <span class="px-4 py-2 text-sm font-medium text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-300 rounded-lg">Aprovado</span>
                                    @elseif($enrollment->pivot->status == 'rejected')
                                         <span class="px-4 py-2 text-sm font-medium text-red-800 bg-red-100 dark:bg-red-900 dark:text-red-300 rounded-lg">Rejeitado</span>
                                    @endif
                                @else
                                    <form action="{{ route('enroll.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md">
                                            Solicitar Matrícula
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">Nenhuma turma encontrada com os filtros aplicados.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
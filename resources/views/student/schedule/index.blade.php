<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Meu Horário de Aulas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Definimos os dias da semana para criar as colunas --}}
            @php
                $daysOfWeek = ['segunda', 'terca', 'quarta', 'quinta', 'sexta'];
            @endphp

            {{-- Container da grade com 5 colunas em telas médias e grandes --}}
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                {{-- Loop para criar cada coluna de dia da semana --}}
                @foreach($daysOfWeek as $day)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                        {{-- Cabeçalho da coluna com o nome do dia --}}
                        <h3 class="font-bold text-lg text-center border-b pb-2 mb-4 capitalize dark:border-gray-700 dark:text-gray-200">
                            {{ $day }}-feira
                        </h3>

                        <div class="space-y-4">
                            {{-- Verificamos se existem aulas para este dia --}}
                            @if(isset($schedules[$day]) && $schedules[$day]->isNotEmpty())
                                {{-- Se existirem, fazemos um loop por elas --}}
                                @foreach($schedules[$day] as $enrollment)
                                    <div class="p-3 bg-indigo-50 dark:bg-indigo-900/50 rounded-lg border border-indigo-200 dark:border-indigo-800">
                                        <p class="font-semibold text-indigo-800 dark:text-indigo-300">{{ $enrollment->subject->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $enrollment->teacher->name }}
                                        </p>
                                        <p class="text-sm font-mono text-gray-800 dark:text-gray-300 mt-1">
                                            🕒 {{ \Carbon\Carbon::parse($enrollment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($enrollment->end_time)->format('H:i') }}
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                {{-- Se não houver aulas, mostramos uma mensagem --}}
                                <div class="text-center text-gray-400 dark:text-gray-500 pt-8">
                                    <p>Nenhuma aula neste dia.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
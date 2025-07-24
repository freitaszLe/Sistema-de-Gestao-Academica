<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Meu Horário de Aulas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @php
                        $daysOfWeek = ['segunda', 'terca', 'quarta', 'quinta', 'sexta'];
                    @endphp

                    @forelse($daysOfWeek as $day)
                        @if(isset($schedules[$day]) && $schedules[$day]->isNotEmpty())
                            <div class="mb-8">
                                <h3 class="text-lg font-bold border-b pb-2 mb-4 capitalize dark:border-gray-700">{{ $day }}-feira</h3>
                                <div class="space-y-4">
                                    @foreach($schedules[$day] as $enrollment)
                                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <p class="font-semibold">{{ $enrollment->subject->name }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Professor(a): {{ $enrollment->teacher->name }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Horário: {{ \Carbon\Carbon::parse($enrollment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($enrollment->end_time)->format('H:i') }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @empty
                         <p class="text-center text-gray-500 p-4">Você ainda não está matriculado em nenhuma turma.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
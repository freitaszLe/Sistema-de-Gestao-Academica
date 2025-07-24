<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Catálogo de Turmas Disponíveis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach ($schedules as $schedule)
                        <div class="flex justify-between items-center p-4 border-b dark:border-gray-700">
                            <div>
                                <p class="font-bold text-lg">{{ $schedule->subject->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $schedule->teacher->name }} - {{ ucfirst($schedule->day_of_week) }}s ({{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }})
                                </p>
                            </div>
                            <div>
                                @php
                                    $enrollment = $enrollments->get($schedule->id);
                                @endphp

                                @if($enrollment)
                                    @if($enrollment->pivot->status == 'pending')
                                        <span class="px-4 py-2 text-sm font-medium text-yellow-800 bg-yellow-100 rounded-lg">Pendente</span>
                                    @elseif($enrollment->pivot->status == 'approved')
                                        <span class="px-4 py-2 text-sm font-medium text-green-800 bg-green-100 rounded-lg">Aprovado</span>
                                    @elseif($enrollment->pivot->status == 'rejected')
                                         <span class="px-4 py-2 text-sm font-medium text-red-800 bg-red-100 rounded-lg">Rejeitado</span>
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
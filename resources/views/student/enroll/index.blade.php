<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Turmas Disponíveis para Matrícula
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach ($schedules as $schedule)
                        <div class="flex justify-between items-center p-4 border-b dark:border-gray-700">
                            <div>
                                <p class="font-bold text-lg">{{ $schedule->subject->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $schedule->teacher->name }} - {{ ucfirst($schedule->day_of_week) }}s das {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} às {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                </p>
                            </div>
                            <div>
                                @if(in_array($schedule->id, $enrolled_ids))
                                    <span class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-200 dark:bg-gray-700 rounded-lg">Inscrito</span>
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
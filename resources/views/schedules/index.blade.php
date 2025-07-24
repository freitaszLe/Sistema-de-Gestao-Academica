<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Gerenciar Turmas e Horários
            </h2>
            <a href="{{ route('schedules.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md">
                + Cadastrar Turma
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Disciplina</th>
                                <th scope="col" class="px-6 py-3">Professor</th>
                                <th scope="col" class="px-6 py-3">Dia da Semana</th>
                                <th scope="col" class="px-6 py-3">Horário</th>
                                <th scope="col" class="px-6 py-3 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($schedules as $schedule)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $schedule->subject->name }}</td>
                                    <td class="px-6 py-4">{{ $schedule->teacher->name }}</td>
                                    <td class="px-6 py-4 capitalize">{{ $schedule->day_of_week }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                    <td class="px-6 py-4 flex gap-2 justify-end">
                                        <a href="{{ route('schedules.edit', $schedule) }}" class="font-medium text-indigo-600 hover:underline">Editar</a>
                                        <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Tem certeza?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:underline">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center">Nenhuma turma cadastrada.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
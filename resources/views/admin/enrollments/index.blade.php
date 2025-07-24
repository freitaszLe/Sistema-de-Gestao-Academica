<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gerenciar Solicitações de Matrícula
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
                    @forelse ($enrollments as $enrollment)
                        <div class="flex flex-col md:flex-row justify-between items-center p-4 border-b dark:border-gray-700">
                            <div>
                                <p class="font-bold text-lg">{{ $enrollment->student->name }}</p>
                                <p class="text-sm">Solicitou matrícula em: <span class="font-semibold">{{ $enrollment->schedule->subject->name }}</span></p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    (Professor: {{ $enrollment->schedule->teacher->name }} - {{ ucfirst($enrollment->schedule->day_of_week) }}s, {{ \Carbon\Carbon::parse($enrollment->schedule->start_time)->format('H:i') }})
                                </p>
                            </div>
                            <div class="flex items-center gap-2 mt-4 md:mt-0">
                                {{-- Formulário de Aprovação --}}
                                <form action="{{ route('admin.enrollments.update', $enrollment->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="px-3 py-1 text-sm bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg">Aprovar</button>
                                </form>
                                {{-- Formulário de Rejeição --}}
                                <form action="{{ route('admin.enrollments.update', $enrollment->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg">Rejeitar</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 p-4">Nenhuma solicitação de matrícula pendente.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
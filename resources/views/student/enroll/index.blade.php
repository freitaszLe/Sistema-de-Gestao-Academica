<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Minhas Solicitações de Matrícula
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @forelse ($enrollments as $enrollment)
                        <div class="flex justify-between items-center p-4 border-b dark:border-gray-700">
                            <div>
                                <p class="font-bold text-lg">{{ $enrollment->subject->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $enrollment->teacher->name }}</p>
                            </div>
                                <div>
                                    @if($enrollment->pivot->status == 'pending')
                                        <div class="flex items-center gap-4">
                                            <span class="px-4 py-2 text-sm font-medium text-yellow-800 bg-yellow-100 rounded-lg">Pendente</span>
                                            {{-- Formulário de Cancelamento --}}
                                            <form action="{{ route('enroll.destroy', $enrollment->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar esta solicitação?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-600 hover:underline">Cancelar</button>
                                            </form>
                                        </div>
                                    @elseif($enrollment->pivot->status == 'approved')
                                        <span class="px-4 py-2 text-sm font-medium text-green-800 bg-green-100 rounded-lg">Aprovado</span>
                                    @elseif($enrollment->pivot->status == 'rejected')
                                        <span class="px-4 py-2 text-sm font-medium text-red-800 bg-red-100 rounded-lg">Rejeitado</span>
                                    @endif
                                </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Você ainda não solicitou matrícula em nenhuma turma.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
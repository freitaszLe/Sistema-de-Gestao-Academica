<x-app-layout>
    {{-- O cabeçalho da página já tem um bom estilo, vamos mantê-lo --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Gerenciar Disciplinas
            </h2>
            <a href="{{ route('subjects.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md">
                + Adicionar Disciplina
            </a>
        </div>
    </x-slot>

    {{-- 👇 A MUDANÇA PRINCIPAL ACONTECE AQUI DENTRO 👇 --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alerta de sucesso --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Sucesso</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Card principal que envolve a tabela --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nome da Disciplina</th>
                                    <th scope="col" class="px-6 py-3">Descrição</th>
                                    <th scope="col" class="px-6 py-3 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subjects as $subject)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $subject->name }}</td>
                                        <td class="px-6 py-4">{{ Str::limit($subject->description, 80) }}</td>
                                        <td class="px-6 py-4 flex gap-2 justify-end">
                                            <a href="{{ route('subjects.edit', $subject) }}" class="font-medium text-indigo-600 dark:text-indigo-500 hover:underline">Editar</a>
                                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('Tem certeza?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center">Nenhuma disciplina cadastrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
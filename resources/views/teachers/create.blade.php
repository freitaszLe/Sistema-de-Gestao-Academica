<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Adicionar Novo Professor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('teachers.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome da Professor</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-md shadow-sm" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email (Opcional)</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-md shadow-sm">
                            </div>
                        </div>
                        <div class="mt-6 flex items-center gap-4">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md">Salvar Professor</button>
                            <a href="{{ route('teachers.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
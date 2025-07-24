<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Turma
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('schedules.update', $schedule) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Dropdown de Disciplinas --}}
                            <div>
                                <label for="subject_id" class="block text-sm font-medium">Disciplina</label>
                                <select name="subject_id" id="subject_id" class="mt-1 block w-full" required>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ $schedule->subject_id == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Dropdown de Professores --}}
                            <div>
                                <label for="teacher_id" class="block text-sm font-medium">Professor</label>
                                <select name="teacher_id" id="teacher_id" class="mt-1 block w-full" required>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ $schedule->teacher_id == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Dia da Semana --}}
                            <div>
                                <label for="day_of_week" class="block text-sm font-medium">Dia da Semana</label>
                                <select name="day_of_week" id="day_of_week" class="mt-1 block w-full" required>
                                    <option value="segunda" {{ $schedule->day_of_week == 'segunda' ? 'selected' : '' }}>Segunda-feira</option>
                                    <option value="terca" {{ $schedule->day_of_week == 'terca' ? 'selected' : '' }}>Terça-feira</option>
                                    <option value="quarta" {{ $schedule->day_of_week == 'quarta' ? 'selected' : '' }}>Quarta-feira</option>
                                    <option value="quinta" {{ $schedule->day_of_week == 'quinta' ? 'selected' : '' }}>Quinta-feira</option>
                                    <option value="sexta" {{ $schedule->day_of_week == 'sexta' ? 'selected' : '' }}>Sexta-feira</option>
                                </select>
                            </div>
                            {{-- Horários --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="start_time" class="block text-sm font-medium">Horário de Início</label>
                                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $schedule->start_time) }}" class="mt-1 block w-full" required>
                                </div>
                                <div>
                                    <label for="end_time" class="block text-sm font-medium">Horário de Fim</label>
                                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $schedule->end_time) }}" class="mt-1 block w-full" required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center gap-4">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-lg">Atualizar Turma</button>
                            <a href="{{ route('schedules.index') }}" class="text-sm">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
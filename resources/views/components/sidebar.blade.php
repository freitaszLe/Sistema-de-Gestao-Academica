<div class="w-64 h-screen bg-gray-900 text-white flex flex-col fixed top-0 left-0 border-r border-gray-200 dark:border-gray-700">

    {{-- Logo / Título do Sistema --}}
    <div class="px-6 h-16 flex items-center justify-center border-b border-gray-700">
        <h2 class="font-bold text-xl text-center text-gray-200">Gestão Acadêmica</h2>
    </div>

    {{-- Menu de Navegação --}}
    <nav class="flex-grow px-4 py-4">
        {{-- Link do Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center px-4 py-2 mt-2 text-sm font-semibold rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white
                  {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-white' : '' }}">
            <span class="mr-3">🏠</span>
            Dashboard
        </a>

        {{-- Links do Administrador --}}
        @if(auth()->user()->isAdmin())
            <p class="px-4 pt-4 pb-2 text-xs text-gray-400 uppercase">Administração</p>
            <a href="{{ route('subjects.index') }}"
               class="flex items-center px-4 py-2 mt-2 text-sm font-semibold rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white
                      {{ request()->routeIs('subjects.*') ? 'bg-gray-700 text-white' : '' }}">
                <span class="mr-3">📚</span>
                Disciplinas
            </a>
            <a href="{{ route('teachers.index') }}"
                class="flex items-center px-4 py-2 mt-2 text-sm font-semibold rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white
                    {{ request()->routeIs('teachers.*') ? 'bg-gray-700 text-white' : '' }}">
                <span class="mr-3">👨‍🏫</span>
                Professores
            </a>
            {{-- ... links de Disciplinas e Professores ... --}}

        <a href="{{ route('schedules.index') }}"
        class="flex items-center px-4 py-2 mt-2 text-sm font-semibold rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white
                {{ request()->routeIs('schedules.*') ? 'bg-gray-700 text-white' : '' }}">
            <span class="mr-3">🕒</span>
            Turmas/Horários
        </a>
                {{-- ... links de aprovar matrículas ... --}}
        <a href="{{ route('admin.enrollments.index') }}"
        class="flex items-center px-4 py-2 mt-2 text-sm font-semibold rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white
                {{ request()->routeIs('admin.enrollments.index') ? 'bg-gray-700 text-white' : '' }}">
            <span class="mr-3">🎓</span>
            Matrículas
        </a>

        @endif

        {{-- Links do Aluno --}}
        @if(auth()->user()->isStudent())
            <p class="px-4 pt-4 pb-2 text-xs text-gray-400 uppercase">Área do Aluno</p>
            <a href="{{ route('my-schedule.index') }}"
            class="flex items-center px-4 py-2 mt-2 text-sm font-semibold rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white
                    {{ request()->routeIs('my-schedule.index') ? 'bg-gray-700 text-white' : '' }}">
                <span class="mr-3">📅</span>
                Meu Horário
            </a>
            <a href="{{ route('enroll.index') }}"
            class="flex items-center px-4 py-2 mt-2 text-sm font-semibold rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white
                    {{ request()->routeIs('enroll.index') ? 'bg-gray-700 text-white' : '' }}">
                <span class="mr-3">📚</span>
                Minhas Solicitações
            </a>
        @endif
    </nav>

    </div>

<div class="w-64"></div>

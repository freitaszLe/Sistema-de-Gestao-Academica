<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('subjects.index');
        }

        if ($user->isStudent()) {
            // Inicia a query para buscar as turmas
            $schedulesQuery = Schedule::query();

            // Filtro por nome da disciplina
            if ($request->filled('search_subject')) {
                $schedulesQuery->whereHas('subject', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search_subject . '%');
                });
            }

            // Filtro por professor
            if ($request->filled('search_teacher')) {
                $schedulesQuery->where('teacher_id', $request->search_teacher);
            }

            // Filtro por dia da semana
            if ($request->filled('search_day')) {
                $schedulesQuery->where('day_of_week', $request->search_day);
            }

            // Executa a query final
            $schedules = $schedulesQuery->with(['subject', 'teacher'])->get();

            // Busca todos os professores para o dropdown
            $teachers = Teacher::orderBy('name')->get();

            // 👇 CORREÇÃO AQUI 👇
            // Busca apenas as matrículas do aluno e organiza pelo ID da turma para fácil acesso na view
            $enrollments = $user->enrollments()->get()->keyBy('pivot.schedule_id');

            return view('dashboard', [
                'schedules' => $schedules,
                'enrollments' => $enrollments,
                'teachers' => $teachers,
            ]);
        }
    }
}
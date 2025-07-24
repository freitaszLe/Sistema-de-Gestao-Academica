<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Enrollment;
class EnrollmentController extends Controller
{
    public function index()
    {
        // Pega todas as turmas com seus relacionamentos para evitar N+1 queries
        $schedules = Schedule::with(['subject', 'teacher'])->get();
        // Pega os IDs das turmas em que o aluno já se inscreveu (qualquer status)
        $enrolled_ids = Auth::user()->enrollments()->pluck('schedules.id')->toArray();

        return view('student.enroll.index', [
            'schedules' => $schedules,
            'enrolled_ids' => $enrolled_ids,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['schedule_id' => 'required|exists:schedules,id']);

        $user = Auth::user();
        // O método attach() adiciona o registro na tabela pivô
        $user->enrollments()->attach($request->schedule_id);

        return back()->with('success', 'Solicitação de matrícula enviada com sucesso!');
    }

    public function mySchedule()
    {
        $user = Auth::user();

        // Busca as matrículas APROVADAS do usuário logado.
        // O 'wherePivot' filtra os dados da tabela pivô (enrollments).
        $approvedEnrollments = $user->enrollments()
                                    ->wherePivot('status', 'approved')
                                    ->with(['subject', 'teacher']) // Carrega os dados da turma
                                    ->get()
                                    ->groupBy('day_of_week'); // Agrupa por dia da semana

        return view('student.schedule.index', ['schedules' => $approvedEnrollments]);
    }
    
}
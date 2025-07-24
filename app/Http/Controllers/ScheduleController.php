<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['teacher', 'subject'])->latest()->get();
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();

        return view('schedules.create', [
            'subjects' => $subjects,
            'teachers' => $teachers,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'day_of_week' => 'required|string|max:10',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        Schedule::create($validated);

        return redirect()->route('schedules.index')->with('success', 'Horário criado com sucesso!');
    }

    public function edit(Schedule $schedule)
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();

        return view('schedules.edit', [
            'schedule' => $schedule,
            'subjects' => $subjects,
            'teachers' => $teachers,
        ]);
    }
    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'day_of_week' => 'required|string|max:10',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.index')->with('success', 'Horário atualizado com sucesso!');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Horário excluído com sucesso!');
    }
}

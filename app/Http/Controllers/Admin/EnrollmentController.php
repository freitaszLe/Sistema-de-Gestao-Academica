<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;
class EnrollmentController extends Controller
{
    public function index()
    {
        $pendingEnrollments = Enrollment::where('status', 'pending')
            ->with(['student', 'schedule.subject', 'schedule.teacher'])
            ->latest()
            ->get();

        return view('admin.enrollments.index', ['enrollments' => $pendingEnrollments]);
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $enrollment->update(['status' => $request->status]);

        return back()->with('success', 'Matrícula atualizada com sucesso!');
    }
}

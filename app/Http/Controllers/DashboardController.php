<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if($user->isAdmin()){
            return redirect()->route('subjects.index');
        }

        if($user->isStudent()){

            $schedules = Schedule::with(['subject', 'teacher'])->get();

            $enrollments = $user->enrollments()->get()->keyBy('id');

            return view('dashboard', [
                'schedules' => $schedules,
                'enrollments' => $enrollments,
            ]);
        }
    }
}

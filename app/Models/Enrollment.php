<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Enrollment extends Pivot
{
    // Indica o nome da tabela
    protected $table = 'enrollments';

    // Permite preenchimento em massa do status
    protected $fillable = ['status'];

    // Relacionamento para buscar o aluno (User)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relacionamento para buscar a turma (Schedule)
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}

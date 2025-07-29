<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Mockery\Matcher\Subset;

class SubjectController extends Controller
{
    public function index()
    {
        // Busca todas as disciplinas, da mais recente para a mais antiga
        $subjects = Subject::latest()->get();
        return view('subjects.index', compact('subjects'));
    }
    public function create()
    {
        // Lógica para exibir o formulário de criação de disciplina
        return view('subjects.create');
    }
    public function store(Request $request)
    {
        // Lógica para armazenar uma nova disciplina    
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subjects',
            'description' => 'nullable|string',
        ]);
        Subject::create($validated);
        return redirect()->route('subjects.index')->with('success', 'Disciplina criada com sucesso!');
    }
    public function edit(Subject $subject)
    {
        return view('subjects.edit', ['subject' => $subject]);
    }
    public function update(Request $request, Subject $subject)
    {
        // Lógica para atualizar uma disciplina existente
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'description' => 'nullable|string',
        ]);
        $subject->update($validated);
        return redirect()->route('subjects.index')->with('success', 'Disciplina atualizada com sucesso!');
    }
    public function destroy(Subject $subject)
    {
        // Lógica para excluir uma disciplina
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Disciplina excluída com sucesso!');
          
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        $subjects = Subject::where('name', 'LIKE', "%{$query}%")
                           ->limit(5) // Limita a 5 resultados para não poluir a tela
                           ->get();

        return response()->json($subjects);
    }
}

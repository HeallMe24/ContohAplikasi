<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quest;

class QuestController extends Controller
{
    public function index(Request $request)
    {
        $quests = Quest::query();
    
        if ($request->has('search')) {
            $quests->where('title', 'like', '%' . $request->search . '%');
        }
    
        $quests = $quests->get();
    
        return view('quests.index', compact('quests'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        Quest::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'checked' => $request->has('checked'),
        ]);

        return redirect()->route('quests.index')->with('success', 'Quest berhasil ditambahkan!');
    }

    public function edit(Quest $quest)
    {
        return response()->json($quest);
    }

    public function update(Request $request, Quest $quest)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $quest->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'checked' => $request->has('checked'),
        ]);

        return redirect()->route('quests.index')->with('success', 'Quest berhasil diperbarui!');
    }

    public function updateStatus(Request $request, $questId)
    {
        $quest = Quest::find($questId);

        if ($quest) {
            $quest->checked = $request->input('checked');
            $quest->save();

            return response()->json(['success' => true, 'checked' => $quest->checked]);
        }

        return response()->json(['success' => false], 400);
    }


    public function destroy(Quest $quest)
    {
        $quest->delete();
        return redirect()->route('quests.index')->with('success', 'Quest berhasil dihapus!');
    }
}

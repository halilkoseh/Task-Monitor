<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{


    public function updateStatus($id, Request $request)
    {
        // Görevi ID ile bul
        $task = Task::findOrFail($id);

        // Görev durumunu güncelle
        $task->status = $request->status;

        // Değişiklikleri kaydet
        $task->save();

        // Başarılı bir cevap dön
        return response()->json(['success' => true, 'message' => 'Görev durumu güncellendi']);
    }

    public function destroyTasks(Task $task)
    {
        $task->delete();

        return redirect()->route('projects.index')->with('success', 'Başarıyla silindi.');
    }

}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // 🔹 GET ALL (hanya task milik user login)
    public function index()
    {
        $tasks = auth()->user()->tasks;

        return response()->json([
            'success' => true,
            'message' => 'Data ditemukan',
            'data' => $tasks
        ], 200);
    }

    // 🔹 CREATE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'deadline' => 'required|date',
            'status' => 'required|in:pending,process,done'
        ]);

        $task = auth()->user()->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'deadline' => $validated['deadline'],
            'status' => $validated['status']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $task
        ], 201);
    }

    // 🔹 GET BY ID (hanya milik user)
    public function show($id)
    {
        $task = auth()->user()->tasks()->find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data ditemukan',
            'data' => $task
        ], 200);
    }

    // 🔹 UPDATE (hanya milik user)
    public function update(Request $request, $id)
    {
        $task = auth()->user()->tasks()->find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'deadline' => 'required|date',
            'status' => 'required|in:pending,process,done'
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $task
        ], 200);
    }

    // 🔹 DELETE (hanya milik user)
    public function destroy($id)
    {
        $task = auth()->user()->tasks()->find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ], 200);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        $users = User::where('role', 'staff')->get();
        return view('admin.projects.index', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:active,completed,hold',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'progress' => 'nullable|integer|min:0|max:100',
                'user_id' => 'required|exists:users,id',  // CHANGED: required instead of nullable
            ]);

            Project::create($validated);

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Project created successfully!']);
            }

            return back()->with('success', 'Project created successfully!');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $project = Project::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:active,completed,hold',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'progress' => 'nullable|integer|min:0|max:100',
                'user_id' => 'required|exists:users,id',  // CHANGED: required instead of nullable
            ]);

            $project->update($validated);

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Project updated successfully!']);
            }

            return back()->with('success', 'Project updated successfully!');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();

            return back()->with('success', 'Project deleted successfully!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function today()
    {
        $todayProjects = Project::whereDate('start_date', Carbon::today())->get();
        return view('projects.today', compact('todayProjects'));
    }
}
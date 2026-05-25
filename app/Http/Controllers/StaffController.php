<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function dashboard()
    {
        $staffProjects = Project::where('user_id', session('user')['id'])->get();
        return view('staff.dashboard', compact('staffProjects'));
    }

    public function tasks()
    {
        $staffProjects = Project::where('user_id', session('user')['id'])->get();
        return view('staff.tasks', compact('staffProjects'));
    }

    public function submitWork(Request $request)
    {
        try {
            $validated = $request->validate([
                'project_id' => 'required|exists:projects,id',
                'progress' => 'required|integer|min:0|max:100',
                'end_date' => 'nullable|date',
                'description' => 'required|string',
                'attachment' => 'nullable|file|max:5120',
            ]);

            $project = Project::findOrFail($validated['project_id']);

            // Verify the project belongs to this staff member
            if ($project->user_id !== session('user')['id']) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            // Update project progress
            $updateData = ['progress' => $validated['progress']];
            
            // Only update end_date if provided
            if (!empty($validated['end_date'])) {
                $updateData['end_date'] = $validated['end_date'];
            }

            $project->update($updateData);

            // Handle file upload if present
            if ($request->hasFile('attachment')) {
                $request->file('attachment')->store('submissions', 'public');
            }

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Work submitted successfully!']);
            }

            return back()->with('success', 'Work submitted successfully!');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
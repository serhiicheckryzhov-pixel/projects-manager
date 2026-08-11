<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index(): View
    {
        $projects = Project::with(['creator', 'userRelatedTo'])->where('status', ProjectStatus::Active)->latest()->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    public function create(Request $request)
    {
        return view('admin.projects.create');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', ['project' => $project]);
    }

    public function store(StoreProjectRequest $request)
    {
        Project::create([...$request->validated(), 'created_by' => Auth::user()->id]);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Data created successfully.');
    }

    public function update(StoreProjectRequest $request, Project $project)
    {

        $project->update($request->validated());

        return redirect()
            ->route('projects.index')
            ->with('success', 'Data updated successfully.');
    }

    public function delete(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Data deleted successfully.');
    }
}

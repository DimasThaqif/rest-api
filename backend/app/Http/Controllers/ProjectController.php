<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\ProjectService;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $projects = $this->service->getAll($request->user()->id);

        return ProjectResource::collection($projects);
    }

    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $project = $this->service->store($data);

        return new ProjectResource($project);
    }

    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    public function update(StoreProjectRequest $request, Project $project)
    {
        $project = $this->service->update($project, $request->validated());

        return new ProjectResource($project);
    }

    public function destroy(Project $project)
    {
        $this->service->delete($project);

        return response()->json([
            'message' => 'Project deleted'
        ]);
    }
}


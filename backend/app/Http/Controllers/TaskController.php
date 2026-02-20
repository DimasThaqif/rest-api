<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request, $projectId)
    {
        $tasks = $this->service->getTasks($projectId, $request->all());

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request, $projectId)
    {
        $data = $request->validated();
        $data['project_id'] = $projectId;

        $task = $this->service->store($data);

        return new TaskResource($task);
    }

    public function update(StoreTaskRequest $request, Task $task)
    {
        $task = $this->service->update($task, $request->validated());

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $this->service->delete($task);

        return response()->json(['message' => 'Task deleted']);
    }
}

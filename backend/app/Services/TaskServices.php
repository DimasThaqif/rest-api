<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function getTasks($projectId, $filters)
    {
        $query = Task::where('project_id', $projectId);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->paginate(10);
    }

    public function store(array $data)
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data)
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task)
    {
        return $task->delete();
    }
}

<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function all($filters)
    {
        // Filtering & sorting logic
        $query = Task::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (isset($filters['due_date'])) {
            $query->whereDate('due_date', $filters['due_date']);
        }

        if (isset($filters['sort'])) {
            $sort = ltrim($filters['sort'], '-');
            $direction = $filters['sort'][0] === '-' ? 'desc' : 'asc';
            $query->orderBy($sort, $direction);
        }

        return $query->paginate(10);
    }

    public function find($id)
    {
        return Task::findOrFail($id);
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update($id, array $data)
    {
        $task = Task::findOrFail($id);
        $task->update($data);
        return $task;
    }

    public function delete($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }

    public function assignUser($taskId, $userId)
    {
        $task = Task::findOrFail($taskId);
        $task->assignees()->syncWithoutDetaching([$userId]); // prevents duplicates
        return $task->load('assignees');
    }

}

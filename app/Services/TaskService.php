<?php

namespace App\Services;

use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskService
{
    protected $taskRepo;

    public function __construct(TaskRepositoryInterface $taskRepo)
    {
        $this->taskRepo = $taskRepo;
    }

    public function getAllTasks($filters)
    {
        return $this->taskRepo->all($filters);
    }

    public function getTask($id)
    {
        return $this->taskRepo->find($id);
    }

    public function createTask(array $data)
    {
        return $this->taskRepo->create($data);
    }

    public function updateTask($id, array $data)
    {
        return $this->taskRepo->update($id, $data);
    }

    public function deleteTask($id)
    {
        return $this->taskRepo->delete($id);
    }

    public function assignUserToTask($taskId, $userId, $currentUser)
    {
        if (! $currentUser->isAdmin()) {
            abort(403, 'Only admin can assign tasks.');
        }

        return $this->taskRepo->assignUser($taskId, $userId);
    }

}

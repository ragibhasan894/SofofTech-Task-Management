<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $tasks = $this->taskService->getAllTasks($request->all());
        return new TaskCollection($tasks);
    }

    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id; // Set creator
        $task = $this->taskService->createTask($data);
        return new TaskResource($task);
    }

    public function show($id)
    {
        $task = $this->taskService->getTask($id);
        return new TaskResource($task);
    }

    public function update(TaskRequest $request, $id)
    {
        $task = $this->taskService->updateTask($id, $request->validated());
        return new TaskResource($task);
    }

    public function destroy($id)
    {
        $this->taskService->deleteTask($id);
        return response()->json(['message' => 'Task deleted']);
    }

    public function assign(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $task = $this->taskService->assignUserToTask($id, $request->user_id);

        return new TaskResource($task);
    }

}

<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TaskService $taskService;
    protected $taskRepo;

    public function setUp(): void
    {
        parent::setUp();

        $this->taskRepo = Mockery::mock(TaskRepositoryInterface::class);
        $this->taskService = new TaskService($this->taskRepo);
    }

    public function test_admin_can_assign_task_to_other_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user  = User::factory()->create();
        $task  = Task::factory()->create(['user_id' => $admin->id]);

        $this->taskRepo
            ->shouldReceive('assignUser')
            ->once()
            ->with($task->id, $user->id)
            ->andReturn($task);

        $result = $this->taskService->assignUserToTask($task->id, $user->id, $admin);

        $this->assertInstanceOf(Task::class, $result);
    }

    public function test_non_admin_cannot_assign_task()
    {
        $nonAdmin = User::factory()->create(['role' => 'user']);
        $target   = User::factory()->create();
        $task     = Task::factory()->create(['user_id' => $nonAdmin->id]);

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $this->expectExceptionMessage('Only admin can assign tasks.');

        $this->taskService->assignUserToTask($task->id, $target->id, $nonAdmin);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

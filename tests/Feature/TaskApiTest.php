<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user1;
    protected User $user2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
        ]);

        $this->user1 = User::factory()->create(['role' => 'user']);
        $this->user2 = User::factory()->create(['role' => 'user']);
    }

    public function test_user_can_register_and_login()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'New User',
            'email' => 'new@example.com',
            'password' => 'password',
        ]);
        $response->assertStatus(200)->assertJsonStructure(['token']);

        $response = $this->postJson('/api/login', [
            'email' => 'new@example.com',
            'password' => 'password',
        ]);
        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    public function test_admin_can_create_task()
    {
        try {
            $token = $this->admin->createToken('auth')->plainTextToken;

            $response = $this->withToken($token)->postJson('/api/tasks', [
                'title' => 'Test Task',
                'description' => 'Testing...',
                'due_date' => Carbon::now()->format('Y-m-d'),
                'status' => 'Todo',
                'priority' => 'High',
            ]);

            $response->assertStatus(201)->assertJsonFragment(['title' => 'Test Task']);
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
        }

    }

    public function test_user_can_view_tasks()
    {
        $task = Task::factory()->create(['user_id' => $this->admin->id]);

        $token = $this->user1->createToken('auth')->plainTextToken;
        $response = $this->withToken($token)->getJson('/api/tasks');

        $response->assertStatus(200)->assertJsonStructure(['data']);
    }

    public function test_admin_can_assign_task_to_users()
    {
        $task = Task::factory()->create(['user_id' => $this->admin->id]);
        $token = $this->admin->createToken('auth')->plainTextToken;

        $response = $this->withToken($token)->postJson("/api/tasks/{$task->id}/assign", [
            'user_id' => $this->user1->id,
        ]);

        $response->assertStatus(200)->assertJson([
            'task_id' => $task->id,
            'user_id' => $this->user1->id,
        ]);
    }

    public function test_user_cannot_assign_task()
    {
        $task = Task::factory()->create(['user_id' => $this->admin->id]);
        $token = $this->user1->createToken('auth')->plainTextToken;

        $response = $this->withToken($token)->postJson("/api/tasks/{$task->id}/assign", [
            'user_id' => $this->user2->id,
        ]);
        $response->assertStatus(403);
    }

    public function test_task_update_and_delete()
    {
        $task = Task::factory()->create(['user_id' => $this->admin->id]);
        $token = $this->admin->createToken('auth')->plainTextToken;

        $response = $this->withToken($token)->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated',
            'status' => 'In Progress',
            'priority' => 'Low',
        ]);
        $response->assertStatus(200)->assertJsonFragment(['title' => 'Updated']);

        $response = $this->withToken($token)->deleteJson("/api/tasks/{$task->id}");
        $response->assertStatus(200)->assertJson(['message' => 'Task deleted']);
    }
}

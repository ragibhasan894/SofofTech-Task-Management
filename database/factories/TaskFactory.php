<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'    => User::factory(),
            'title'      => $this->faker->sentence,
            'description'=> $this->faker->paragraph,
            'due_date'   => now()->addDays(rand(1, 10)),
            'status'     => $this->faker->randomElement(['Todo', 'In Progress', 'Done']),
            'priority'   => $this->faker->randomElement(['Low', 'Medium', 'High']),
        ];
    }
}

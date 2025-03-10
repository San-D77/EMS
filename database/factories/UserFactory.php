<?php

namespace Database\Factories;

use App\Models\Backend\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        $alias = explode(' ',$name)[0].' '.explode(' ',$name)[1];
        $slug = Str::slug($alias);
        $role = Role::find(random_int(1, Role::count()));
        $employment_type = config("constants.employment_types")[random_int(0, (count(config("constants.employment_types"))-1))];
        $standard_task= '';
        $standard_time = '';
        if($employment_type == "full-time"){
            $standard_time = "08:00";
            $standard_task = random_int(2,4);
        }
        return [
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'alias_name' => $alias,
            'slug' => $slug,
            'role_id' => $role->id,
            "designation" => config("constants.designations")[random_int(0, (count(config("constants.designations"))-2))],
            "employment_type" => $employment_type,
            "standard_time" => $standard_time,
            "standard_task" => $standard_task
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

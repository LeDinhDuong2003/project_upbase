<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'user_id' => random_int(1,5), // Tự động tạo một User
            'title' => $this->faker->sentence(), // Tiêu đề giả lập
            'content' => $this->faker->paragraph(5), // Nội dung giả lập (5 đoạn văn)
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

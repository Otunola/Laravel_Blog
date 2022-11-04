<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Auth\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $user = User::inRandomOrder()->first();
        $post = Post::inRandomOrder()->first();


        return [
            'post_id' =>$post->id,
            'user_id' => $user->id,
            'comment' => fake()->paragraph(2),
            'status' => 'approved'

        ];

    }
}

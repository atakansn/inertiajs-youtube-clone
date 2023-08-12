<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\User;
use App\Traits\HasChannelPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Channel>
 */
class ChannelFactory extends Factory
{
    use HasChannelPhoto;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Channel::class;

    public function definition(): array
    {
        $randomUserId = User::inRandomOrder()->first()->id;

        return [
            'id' => Str::ulid(),
            'name' => Str::upper($this->faker->firstName() . Str::random(5)),
            'user_id' => $randomUserId,
            'identifier' => Str::slug($this->faker->firstName()) . Str::random(3),
            'photo' => $this->avatar($this->faker->name()),
            'cover_photo' => 'https://images.unsplash.com/photo-1550293038-06c7e135fcc8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1171&q=80'
        ];
    }
}

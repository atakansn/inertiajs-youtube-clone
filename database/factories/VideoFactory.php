<?php

namespace Database\Factories;

use App\Enums\VideoPublished;
use App\Models\Channel;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::ulid(),
            'channel_id' => Channel::inRandomOrder()->first()->id,
            'title' => $this->faker->name(),
            'description' => $this->faker->text,
            'thumbnail' => $this->faker->imageUrl(),
            'view_count' => 0,
            'duration' => $this->randomVideoDuration(
                hours: rand(0, 2),
                minutes: rand(0, 59),
                seconds: rand(0, 59)
            ),
            'is_published' => VideoPublished::UNPUBLISHED,
            'processing_percentage' => 100,
        ];
    }

    private function randomVideoDuration(int $hours, int $minutes, int $seconds): int
    {
        return $hours * 3600 + $minutes * 60 + $seconds;
    }
}

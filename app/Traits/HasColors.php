<?php

namespace App\Traits;

trait HasColors
{
    protected function getColors(): array
    {
        return config('colors');
    }

    protected function generateRandomColor(): string
    {
        $colors = $this->getColors();

        $randomColor = array_rand($colors);
        $colorCode = $colors[$randomColor];
        return ltrim($colorCode, '#');
    }

    protected function avatar(string $name)
    {
        return "https://ui-avatars.com/api/?background={$this->generateRandomColor()}&color=fff&name={$name}&bold=true";
    }

    private function url(): string
    {
        return "https://ui-avatars.com/api/";
    }
}

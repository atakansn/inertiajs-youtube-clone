<?php

namespace Tests\Feature;

use App\Traits\HasColors;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HexColorTraitTest extends TestCase
{

    use HasColors;

    public function test_is_valid_hex_color_valid_color_returns()
    {

        $colors = config('colors');

        $randomColor = array_rand($colors);
        $colorCode = $colors[$randomColor];
        $color = ltrim($colorCode, '#');
        $link = "https://ui-avatars.com/api/?background={$color}&color=fff";

        dd($link);

        $this->assertSame("https://ui-avatars.com/api/?background={$color}&color=fff", $link,$link);
    }
}

<?php

use arnostalpaert\Transformers\Rijksdriehoek;
use PHPUnit\Framework\TestCase;

final class Rijksdriehoektest extends TestCase
{
    /** @var array $latLon */
    protected $latLon = [
        'lat' => 4.234972792282486,
        'lon' => 52.007952964842566
    ];

    /** @test */
    public function it_transforms_x_y_to_correct_lat_lon()
    {
        // Checked with online tool: https://epsg.io/transform?fbclid=IwAR2lxl56hSve5laZuzkkiZe34sW6jBI3JIdsrH0jOs4-6FkdDq8Unky9SHg#s_srs=28992&t_srs=4326&x=75890.1990000&y=447247.6640000

        $this->assertEquals(
            $this->latLon,
            Rijksdriehoek::toLatLon([
                75890.199, // x
                447247.664 // y
            ])
        );
    }

    /** @test */
    public function it_cannot_transform_x_y_to_correct_lat_lon()
    {
        $this->assertNotEquals(
            $this->latLon,
            Rijksdriehoek::toLatLon([
                0, // x
                0 // y
            ])
        );
    }

    /** @test */
    public function it_succeeds_when_x_y_is_array()
    {
        $this->assertIsArray($this->latLon);
    }

    /** @test */
    public function it_fails_when_x_y_is_not_array()
    {
        $this->assertIsNotArray("4.234972792282486, 52.007952964842566");
    }
}
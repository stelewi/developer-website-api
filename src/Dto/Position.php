<?php

namespace App\Dto;

class Position implements PositionInterface
{
    protected float $x;
    protected float $y;
    protected float $z;

    private function __construct(float $x, float $y, float $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public function getX(): float
    {
        return $this->x;
    }

    public function getY(): float
    {
        return $this->y;
    }

    public function getZ(): float
    {
        return $this->z;
    }

    public static function create(float $x, float $y, float $z): self
    {
        return new self($x, $y, $z);
    }
}

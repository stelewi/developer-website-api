<?php

namespace App\Dto;

interface PositionInterface
{
    public function getX(): float;

    public function getY(): float;

    public function getZ(): float;
}

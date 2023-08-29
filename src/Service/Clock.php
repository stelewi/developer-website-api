<?php

namespace App\Service;

class Clock implements ClockInterface
{
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now');
    }
}

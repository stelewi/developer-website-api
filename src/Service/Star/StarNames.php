<?php

namespace App\Service\Star;

class StarNames
{
    /**
     * @var array<string>
     */
    protected array $names;

    public function __construct()
    {
        $this->names = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'star-names.json'));
    }

    public function getNames(): array
    {
        return $this->names;
    }
}

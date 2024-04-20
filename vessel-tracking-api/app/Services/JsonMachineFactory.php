<?php

namespace App\Services;

use ArrayObject;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class JsonMachineFactory
{
    /**
     * @throws InvalidArgumentException
     */
    public function createFileReader(string $file): Items|ArrayObject
    {
        return Items::fromFile($file);
    }
}

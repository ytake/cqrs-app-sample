<?php
declare(strict_types=1);

namespace SampleDomain\Support\ValueObject;

use SampleDomain\Support\Exception\InvalidNativeArgumentException;

class IntegerIdentifier
{
    private int $id;

    /**
     * @param int $id
     */
    public function __construct(
        int $id
    ) {
        if ($id < 0) {
            throw new InvalidNativeArgumentException();
        }
        $this->id =$id;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->id;
    }
}

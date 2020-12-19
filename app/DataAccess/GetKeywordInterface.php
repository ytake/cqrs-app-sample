<?php
declare(strict_types=1);

namespace App\DataAccess;

interface GetKeywordInterface
{
    /**
     * @return array
     */
    public function findAll(): array;
}

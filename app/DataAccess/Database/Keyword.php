<?php
declare(strict_types=1);

namespace App\DataAccess\Database;

use Illuminate\Database\DatabaseManager;
use SampleDomain\Keyword\Entity\KeywordCriteriaInterface;

final class Keyword implements KeywordCriteriaInterface
{
    public function __construct(
        private DatabaseManager $databaseManager
    ) {
    }

    public function add(
        \SampleDomain\Keyword\Entity\Keyword $word
    ): void {
        $this->databaseManager->table('keywords')
            ->insert([
                'word' => $word->getWord(),
                'user_id' => $word->getUserId()->value()
            ]);
    }
}

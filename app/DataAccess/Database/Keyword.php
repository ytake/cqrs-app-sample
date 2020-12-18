<?php
declare(strict_types=1);

namespace App\DataAccess\Database;

use Illuminate\Database\DatabaseManager;

final class Keyword
{
    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(
        private DatabaseManager $databaseManager
    ) {
    }

    /**
     * @param \SampleDomain\Keyword\Entity\Keyword $word
     */
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

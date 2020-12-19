<?php
declare(strict_types=1);

return [
    'hosts' => \explode(',', \env('ES_CLIENT')),
    'keyword_index' => 'words',
];

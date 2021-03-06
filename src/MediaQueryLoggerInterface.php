<?php

declare(strict_types=1);

namespace Ray\MediaQuery;

use Ray\MediaQuery\Annotation\QueryId;

interface MediaQueryLoggerInterface
{
    public function start(): void;

    /**
     * @param array<string, mixed> $params
     */
    public function log(string $queryId, array $params): void;

    public function __toString(): string;
}
